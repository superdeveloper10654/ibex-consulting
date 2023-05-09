/*!
 * @license
 * 
 * dhtmlxGantt v.5.1.0 Professional
 * This software is covered by DHTMLX Enterprise License. Usage without proper license is prohibited.
 * 
 * (c) Dinamenta, UAB.
 * 
 */
Gantt.plugin(function(e) {
    ! function(e) {
        function t(l) {
            if (s[l]) return s[l].exports;
            var i = s[l] = {
                i: l,
                l: !1,
                exports: {}
            };
            return e[l].call(i.exports, i, i.exports, t), i.l = !0, i.exports
        }
        var s = {};
        t.m = e, t.c = s, t.d = function(e, s, l) {
            t.o(e, s) || Object.defineProperty(e, s, {
                configurable: !1,
                enumerable: !0,
                get: l
            })
        }, t.n = function(e) {
            var s = e && e.__esModule ? function() {
                return e.default
            } : function() {
                return e
            };
            return t.d(s, "a", s), s
        }, t.o = function(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        }, t.p = "", t(t.s = 27)
    }({
        27: function(e, t, s) {
            e.exports = s(28)
        },
        28: function(t, s) {
            e.config.multiselect = !0, e.config.multiselect_one_level = !1, e._multiselect = {
                    _selected: {},
                    _one_level: !1,
                    _active: !0,
                    _first_selected_when_shift: null,
                    getDefaultSelected: function() {
                        var e = this.getSelected();
                        return e.length ? e[e.length - 1] : null
                    },
                    setFirstSelected: function(e) {
                        this._first_selected_when_shift = e
                    },
                    getFirstSelected: function() {
                        return this._first_selected_when_shift
                    },
                    isActive: function() {
                        return this.updateState(), this._active
                    },
                    updateState: function() {
                        this._one_level = e.config.multiselect_one_level;
                        var t = this._active;
                        this._active = e.config.multiselect, this._active != t && this.reset()
                    },
                    reset: function() {
                        this._selected = {}
                    },
                    setLastSelected: function(t) {
                        e.$data.tasksStore.silent(function() {
                            var s = e.$data.tasksStore;
                            t ? s.select(t + "") : s.unselect(null)
                        })
                    },
                    getLastSelected: function() {
                        var t = e.$data.tasksStore.getSelectedId();
                        return t && e.isTaskExists(t) ? t : null
                    },
                    select: function(t, s) {
                        return !!(t && e.callEvent("onBeforeTaskMultiSelect", [t, !0, s]) && e.callEvent("onBeforeTaskSelected", [t])) && (this._selected[t] = !0, this.setLastSelected(t), this.afterSelect(t), e.callEvent("onTaskMultiSelect", [t, !0, s]), e.callEvent("onTaskSelected", [t]), !0)
                    },
                    toggle: function(e, t) {
                        this._selected[e] ? this.unselect(e, t) : this.select(e, t)
                    },
                    unselect: function(t, s) {
                        t && e.callEvent("onBeforeTaskMultiSelect", [t, !1, s]) && (this._selected[t] = !1, this.getLastSelected() == t && this.setLastSelected(this.getDefaultSelected()), this.afterSelect(t), e.callEvent("onTaskMultiSelect", [t, !1, s]), e.callEvent("onTaskUnselected", [t]))
                    },
                    isSelected: function(t) {
                        return !(!e.isTaskExists(t) || !this._selected[t])
                    },
                    getSelected: function() {
                        var t = [];
                        for (var s in this._selected) this._selected[s] && e.isTaskExists(s) ? t.push(s) : this._selected[s] = !1;
                        return t.sort(function(t, s) {
                            return e.getGlobalTaskIndex(t) > e.getGlobalTaskIndex(s) ? 1 : -1
                        }), t
                    },
                    forSelected: function(e) {
                        for (var t = this.getSelected(), s = 0; s < t.length; s++) e(t[s])
                    },
                    isSameLevel: function(t) {
                        if (!this._one_level) return !0;
                        var s = this.getLastSelected();
                        return !s || (!e.isTaskExists(s) || !e.isTaskExists(t) || !(e.calculateTaskLevel(e.getTask(s)) != e.calculateTaskLevel(e.getTask(t))))
                    },
                    afterSelect: function(t) {
                        e.isTaskExists(t) && e.refreshTask(t)
                    },
                    doSelection: function(t) {
                        if (!this.isActive()) return !1;
                        if (e._is_icon_open_click(t)) return !1;
                        var s = e.locate(t);
                        if (!s) return !1;
                        if (!e.callEvent("onBeforeMultiSelect", [t])) return !1;
                        var l = this.getSelected(),
                            i = this.getFirstSelected(),
                            c = !1,
                            n = this.getLastSelected();
                        if (t.shiftKey ? e.isTaskExists(this.getFirstSelected()) && null !== this.getFirstSelected() || this.setFirstSelected(s) : t.ctrlKey || t.metaKey ? this.isSelected(s) || this.setFirstSelected(s) : this.setFirstSelected(s), t.ctrlKey || t.metaKey) s && this.toggle(s, t);
                        else if (t.shiftKey && l.length)
                            if (n) {
                                if (s) {
                                    for (var a = e.getGlobalTaskIndex(this.getFirstSelected()), r = e.getGlobalTaskIndex(s), u = e.getGlobalTaskIndex(n), o = n; e.getGlobalTaskIndex(o) !== a;) this.unselect(o, t), o = a > u ? e.getNext(o) : e.getPrev(o);
                                    for (o = s; e.getGlobalTaskIndex(o) !== a;) this.select(o, t) && !c && (c = !0, i = o), o = a > r ? e.getNext(o) : e.getPrev(o)
                                }
                            } else n = s;
                        else {
                            this.isSelected(s) || this.select(s, t), l = this.getSelected();
                            for (var d = 0; d < l.length; d++) l[d] !== s && this.unselect(l[d], t)
                        }
                        return this.isSelected(s) ? this.setLastSelected(s) : i ? s == n && this.setLastSelected(t.shiftKey ? i : this.getDefaultSelected()) : this.setLastSelected(null), this.getSelected().length || this.setLastSelected(null), this.getLastSelected() && this.isSelected(this.getFirstSelected()) || this.setFirstSelected(this.getLastSelected()), !0
                    }
                },
                function() {
                    var t = e.selectTask;
                    e.selectTask = function(s) {
                        if (!s) return !1;
                        var l = e._multiselect,
                            i = s;
                        return l.isActive() ? (l.select(s, null) && l.setLastSelected(s), l.setFirstSelected(l.getLastSelected())) : i = t.call(this, s), i
                    };
                    var s = e.unselectTask;
                    e.unselectTask = function(t) {
                        var l = e._multiselect,
                            i = l.isActive();
                        (t = t || l.getLastSelected()) && i && (l.unselect(t, null), t == l.getLastSelected() && l.setLastSelected(null), e.refreshTask(t), l.setFirstSelected(l.getLastSelected()));
                        var c = t;
                        return i || (c = s.call(this, t)), c
                    }, e.toggleTaskSelection = function(t) {
                        var s = e._multiselect;
                        t && s.isActive() && (s.toggle(t), s.setFirstSelected(s.getLastSelected()))
                    }, e.getSelectedTasks = function() {
                        var t = e._multiselect;
                        return t.isActive(), t.getSelected()
                    }, e.eachSelectedTask = function(e) {
                        return this._multiselect.forSelected(e)
                    }, e.isSelectedTask = function(e) {
                        return this._multiselect.isSelected(e)
                    }, e.getLastSelectedTask = function() {
                        return this._multiselect.getLastSelected()
                    }
                }(), e.attachEvent("onTaskIdChange", function(t, s) {
                    var l = e._multiselect;
                    if (!l.isActive()) return !0;
                    e.isSelectedTask(t) && (l.unselect(t, null), l.select(s, null))
                }), e.attachEvent("onAfterTaskDelete", function(t, s) {
                    var l = e._multiselect;
                    if (!l.isActive()) return !0;
                    l._selected[t] && (l.unselect(t, null), l._selected[t] = !1, l.setLastSelected(l.getDefaultSelected())), l.forSelected(function(t) {
                        e.isTaskExists(t) || l.unselect(t, null)
                    })
                }), e.attachEvent("onBeforeTaskMultiSelect", function(t, s, l) {
                    var i = e._multiselect;
                    return !(s && i.isActive() && i._one_level) || i.isSameLevel(t)
                }), e.attachEvent("onTaskClick", function(t, s) {
                    return e._multiselect.doSelection(s) && e.callEvent("onMultiSelect", [s]), !0
                })
        }
    })
});
//# sourceMappingURL=dhtmlxgantt_multiselect.js.map