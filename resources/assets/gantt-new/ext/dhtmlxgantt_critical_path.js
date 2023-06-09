/*!
 * @license
 * 
 * dhtmlxGantt v.5.1.0 Professional
 * This software is covered by DHTMLX Enterprise License. Usage without proper license is prohibited.
 * 
 * (c) Dinamenta, UAB.
 * 
 */
Gantt.plugin(function(t) {
    ! function(t) {
        function e(n) {
            if (i[n]) return i[n].exports;
            var r = i[n] = {
                i: n,
                l: !1,
                exports: {}
            };
            return t[n].call(r.exports, r, r.exports, e), r.l = !0, r.exports
        }
        var i = {};
        e.m = t, e.c = i, e.d = function(t, i, n) {
            e.o(t, i) || Object.defineProperty(t, i, {
                configurable: !1,
                enumerable: !0,
                get: n
            })
        }, e.n = function(t) {
            var i = t && t.__esModule ? function() {
                return t.default
            } : function() {
                return t
            };
            return e.d(i, "a", i), i
        }, e.o = function(t, e) {
            return Object.prototype.hasOwnProperty.call(t, e)
        }, e.p = "", e(e.s = 5)
    }([function(t, e) {
        t.exports = function(t) {
            t._get_linked_task = function(e, i) {
                var n = null,
                    r = i ? e.target : e.source;
                t.isTaskExists(r) && (n = t.getTask(r));
                var a = i ? "target" : "source";
                return t.assert(n, "Link " + a + " not found. Task id=" + r + ", link id=" + e.id), n
            }, t._get_link_target = function(e) {
                return t._get_linked_task(e, !0)
            }, t._get_link_source = function(e) {
                return t._get_linked_task(e, !1)
            }, t._formatLink = function(e) {
                var i = [],
                    n = this._get_link_target(e),
                    r = this._get_link_source(e);
                if (!r || !n) return i;
                if (t.isChildOf(r.id, n.id) && t.isSummaryTask(n) || t.isChildOf(n.id, r.id) && t.isSummaryTask(r)) return i;
                for (var a = this._getImplicitLinks(e, r, function(t) {
                        return 0
                    }), s = t.config.auto_scheduling_move_projects, c = this.isSummaryTask(n) ? this.getSubtaskDates(n.id) : {
                        start_date: n.start_date,
                        end_date: n.end_date
                    }, o = this._getImplicitLinks(e, n, function(e) {
                        return s ? e.$target.length || t.getState().drag_id == e.id ? 0 : t.calculateDuration({
                            start_date: c.start_date,
                            end_date: e.start_date,
                            task: r
                        }) : 0
                    }), u = 0; u < a.length; u++)
                    for (var d = a[u], h = 0; h < o.length; h++) {
                        var _ = o[h],
                            l = 1 * d.lag + 1 * _.lag,
                            g = {
                                id: e.id,
                                type: e.type,
                                source: d.task,
                                target: _.task,
                                lag: (1 * e.lag || 0) + l
                            };
                        i.push(t._convertToFinishToStartLink(_.task, g, r, n))
                    }
                return i
            }, t._isAutoSchedulable = function(t) {
                return !1 !== t.auto_scheduling
            }, t._getImplicitLinks = function(t, e, i) {
                var n = [];
                return this.isSummaryTask(e) ? this.eachTask(function(t) {
                    this.isSummaryTask(t) || n.push({
                        task: t.id,
                        lag: i(t)
                    })
                }, e.id) : n.push({
                    task: e.id,
                    lag: 0
                }), n
            }, t._getDirectDependencies = function(t, e) {
                for (var i = [], n = [], r = e ? t.$source : t.$target, a = 0; a < r.length; a++) {
                    var s = this.getLink(r[a]);
                    if (this.isTaskExists(s.source) && this.isTaskExists(s.target)) {
                        var c = this.getTask(s.target);
                        this._isAutoSchedulable(c) && i.push(this.getLink(r[a]))
                    }
                }
                for (var a = 0; a < i.length; a++) n = n.concat(this._formatLink(i[a]));
                return n
            }, t._getInheritedDependencies = function(t, e) {
                var i = [],
                    n = !1,
                    r = [];
                if (this.isTaskExists(t.id)) {
                    this.eachParent(function(t) {
                        n || this.isSummaryTask(t) && (this._isAutoSchedulable(t) ? r.push.apply(r, this._getDirectDependencies(t, e)) : n = !0)
                    }, t.id, this);
                    for (var a = 0; a < r.length; a++) {
                        (e ? r[a].source : r[a].target) == t.id && i.push(r[a])
                    }
                }
                return i
            }, t._getDirectSuccessors = function(t) {
                return this._getDirectDependencies(t, !0)
            }, t._getInheritedSuccessors = function(t) {
                return this._getInheritedDependencies(t, !0)
            }, t._getDirectPredecessors = function(t) {
                return this._getDirectDependencies(t, !1)
            }, t._getInheritedPredecessors = function(t) {
                return this._getInheritedDependencies(t, !1)
            }, t._getSuccessors = function(t) {
                return this._getDirectSuccessors(t).concat(this._getInheritedSuccessors(t))
            }, t._getPredecessors = function(t) {
                return this._getDirectPredecessors(t).concat(this._getInheritedPredecessors(t))
            }, t._convertToFinishToStartLink = function(e, i, n, r) {
                var a = {
                        target: e,
                        link: t.config.links.finish_to_start,
                        id: i.id,
                        lag: i.lag || 0,
                        source: i.source,
                        preferredStart: null
                    },
                    s = 0;
                switch (i.type) {
                    case t.config.links.start_to_start:
                        s = -n.duration;
                        break;
                    case t.config.links.finish_to_finish:
                        s = -r.duration;
                        break;
                    case t.config.links.start_to_finish:
                        s = -n.duration - r.duration;
                        break;
                    default:
                        s = 0
                }
                return a.lag += s, a
            }
        }
    }, , , , , function(t, e, i) {
        t.exports = i(6)
    }, function(e, i, n) {
        n(0)(t), t.config.highlight_critical_path = !1, t._criticalPathHandler = function() {
            t.config.highlight_critical_path && t.render()
        }, t.attachEvent("onAfterLinkAdd", t._criticalPathHandler), t.attachEvent("onAfterLinkUpdate", t._criticalPathHandler), t.attachEvent("onAfterLinkDelete", t._criticalPathHandler), t.attachEvent("onAfterTaskAdd", t._criticalPathHandler), t.attachEvent("onAfterTaskUpdate", t._criticalPathHandler), t.attachEvent("onAfterTaskDelete", t._criticalPathHandler), t._isCriticalTask = function(t, e) {
            if (t && t.id) {
                var i = e || {};
                if (this._isProjectEnd(t)) return !0;
                i[t.id] = !0;
                for (var n = this._getDependencies(t), r = 0; r < n.length; r++) {
                    var a = this.getTask(n[r].target);
                    if (this._getSlack(t, a, n[r]) <= 0 && !i[a.id] && this._isCriticalTask(a, i)) return !0
                }
                return !1
            }
        }, t.isCriticalTask = function(e) {
            return t.assert(!(!e || void 0 === e.id), "Invalid argument for gantt.isCriticalTask"), this._isCriticalTask(e, {})
        }, t.isCriticalLink = function(e) {
            return this.isCriticalTask(t.getTask(e.source))
        }, t.getSlack = function(t, e) {
            for (var i = [], n = {}, r = 0; r < t.$source.length; r++) n[t.$source[r]] = !0;
            for (var r = 0; r < e.$target.length; r++) n[e.$target[r]] && i.push(e.$target[r]);
            for (var a = [], r = 0; r < i.length; r++) {
                var s = this.getLink(i[r]);
                a.push(this._getSlack(t, e, this._convertToFinishToStartLink(s.id, s, t, e)))
            }
            return Math.min.apply(Math, a)
        }, t._getSlack = function(t, e, i) {
            var n = this.config.types,
                r = null;
            r = this.getTaskType(t.type) == n.milestone ? t.start_date : t.end_date;
            var a = e.start_date,
                s = 0;
            s = +r > +a ? -this.calculateDuration({
                start_date: a,
                end_date: r,
                task: t
            }) : this.calculateDuration({
                start_date: r,
                end_date: a,
                task: t
            });
            var c = i.lag;
            return c && 1 * c == c && (s -= c), s
        }, t._getProjectEnd = function() {
            var e = t.getTaskByTime();
            return e = e.sort(function(t, e) {
                return +t.end_date > +e.end_date ? 1 : -1
            }), e.length ? e[e.length - 1].end_date : null
        }, t._isProjectEnd = function(t) {
            return !this._hasDuration({
                start_date: t.end_date,
                end_date: this._getProjectEnd(),
                task: t
            })
        }, t._getSummaryPredecessors = function(e) {
            var i = [];
            return this.eachParent(function(e) {
                this.isSummaryTask(e) && (i = i.concat(t._getDependencies(e)))
            }, e), i
        }, t._getDependencies = function(t) {
            return this._getSuccessors(t).concat(this._getSummaryPredecessors(t))
        }
    }])
});
//# sourceMappingURL=dhtmlxgantt_critical_path.js.map