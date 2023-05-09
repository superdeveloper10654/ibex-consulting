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
        function n(o) {
            if (e[o]) return e[o].exports;
            var i = e[o] = {
                i: o,
                l: !1,
                exports: {}
            };
            return t[o].call(i.exports, i, i.exports, n), i.l = !0, i.exports
        }
        var e = {};
        n.m = t, n.c = e, n.d = function(t, e, o) {
            n.o(t, e) || Object.defineProperty(t, e, {
                configurable: !1,
                enumerable: !0,
                get: o
            })
        }, n.n = function(t) {
            var e = t && t.__esModule ? function() {
                return t.default
            } : function() {
                return t
            };
            return n.d(e, "a", e), e
        }, n.o = function(t, n) {
            return Object.prototype.hasOwnProperty.call(t, n)
        }, n.p = "", n(n.s = 35)
    }({
        35: function(t, n, e) {
            t.exports = e(36)
        },
        36: function(n, e) {
            t.config.undo_steps = 10, t.config.undo = !0, t.config.redo = !0, t.undo = function() {
                    this._undo.undo()
                }, t.getUndoStack = function() {
                    return this._undo._undoStack
                }, t.getRedoStack = function() {
                    return this._undo._redoStack
                }, t.redo = function() {
                    this._undo.redo()
                }, t.config.undo_types = {
                    link: "link",
                    task: "task"
                }, t.config.undo_actions = {
                    update: "update",
                    remove: "remove",
                    add: "add"
                }, t._undo = {
                    _undoStack: [],
                    _redoStack: [],
                    maxSteps: 10,
                    undo_enabled: !0,
                    redo_enabled: !0,
                    _push: function(t, n) {
                        if (n.commands.length) {
                            for (t.push(n); t.length > this.maxSteps;) t.shift();
                            return n
                        }
                    },
                    _pop: function(t) {
                        return t.pop()
                    },
                    undo: function() {
                        if (this.updateConfigs(), this.undo_enabled) {
                            var n = this._pop(this._undoStack);
                            !1 !== t.callEvent("onBeforeUndo", [n]) && n && (this._applyAction(this.action.invert(n)), this._push(this._redoStack, t.copy(n))), t.callEvent("onAfterUndo", [])
                        }
                    },
                    redo: function() {
                        if (this.updateConfigs(), this.redo_enabled) {
                            var n = this._pop(this._redoStack);
                            !1 !== t.callEvent("onBeforeRedo", [n]) && n && (this._applyAction(n), this._push(this._undoStack, t.copy(n))), t.callEvent("onAfterRedo", [])
                        }
                    },
                    _applyAction: function(n) {
                        var e = null,
                            o = this.command.entity,
                            i = this.command.type,
                            a = {};
                        a[o.task] = {
                            add: "addTask",
                            update: "updateTask",
                            remove: "deleteTask",
                            isExists: "isTaskExists"
                        }, a[o.link] = {
                            add: "addLink",
                            update: "updateLink",
                            remove: "deleteLink",
                            isExists: "isLinkExists"
                        }, t.batchUpdate(function() {
                            for (var o = 0; o < n.commands.length; o++) {
                                e = n.commands[o];
                                var s = a[e.entity][e.type],
                                    d = a[e.entity].isExists;
                                e.type == i.add ? t[s](e.oldValue, e.oldValue.parent, e.oldValue.$index) : e.type == i.remove ? t[d](e.value.id) && t[s](e.value.id) : e.type == i.update && t[s](e.value.id, e.value)
                            }
                        })
                    },
                    logAction: function(t) {
                        this._push(this._undoStack, t), this._redoStack = []
                    },
                    action: {
                        create: function(t) {
                            return {
                                commands: t ? t.slice() : []
                            }
                        },
                        invert: function(n) {
                            for (var e = t.copy(n), o = t._undo.command, i = 0; i < n.commands.length; i++) {
                                var a = e.commands[i] = o.invert(e.commands[i]);
                                if (a.type == o.type.update) {
                                    var s = a.value;
                                    a.value = a.oldValue, a.oldValue = s
                                }
                            }
                            return e
                        }
                    },
                    command: {
                        create: function(n, e, o, i) {
                            return {
                                entity: i,
                                type: o,
                                value: t.copy(n),
                                oldValue: t.copy(e || n)
                            }
                        },
                        invert: function(n) {
                            var e = t.copy(n);
                            return e.type = this.inverseCommands(n.type), e
                        },
                        entity: null,
                        type: null,
                        inverseCommands: function(n) {
                            switch (n) {
                                case this.type.update:
                                    return this.type.update;
                                case this.type.remove:
                                    return this.type.add;
                                case this.type.add:
                                    return this.type.remove;
                                case this.type.load:
                                    return this.type.clear;
                                case this.type.clear:
                                    return this.type.load;
                                default:
                                    return t.assert(!1, "Invalid command " + n), null
                            }
                        }
                    },
                    monitor: {
                        _batchAction: null,
                        _batchMode: !1,
                        _ignore: !1,
                        startIgnore: function() {
                            this._ignore = !0
                        },
                        stopIgnore: function() {
                            this._ignore = !1
                        },
                        startBatchAction: function() {
                            this.timeout && clearTimeout(this.timeout), this.timeout = setTimeout(function() {
                                t._undo.monitor.stopBatchAction()
                            }, 10), this._ignore || this._batchMode || (this._batchMode = !0, this._batchAction = t._undo.action.create())
                        },
                        stopBatchAction: function() {
                            if (!this._ignore) {
                                var n = t._undo;
                                this._batchAction && n.logAction(this._batchAction), this._batchMode = !1, this._batchAction = null
                            }
                        },
                        _storeCommand: function(n) {
                            var e = t._undo;
                            if (e.updateConfigs(), e.undo_enabled)
                                if (this._batchMode) this._batchAction.commands.push(n);
                                else {
                                    var o = e.action.create([n]);
                                    e.logAction(o)
                                }
                        },
                        _storeEntityCommand: function(n, e, o, i) {
                            var a = t._undo,
                                s = a.command.create(n, e, o, i);
                            this._storeCommand(s)
                        },
                        _storeTaskCommand: function(n, e) {
                            this._storeEntityCommand(n, this.getInitialTask(n.id), e, t._undo.command.entity.task)
                        },
                        _storeLinkCommand: function(n, e) {
                            this._storeEntityCommand(n, this.getInitialLink(n.id), e, t._undo.command.entity.link)
                        },
                        onTaskAdded: function(n) {
                            this._ignore || this._storeTaskCommand(n, t._undo.command.type.add)
                        },
                        onTaskUpdated: function(n) {
                            this._ignore || this._storeTaskCommand(n, t._undo.command.type.update)
                        },
                        onTaskDeleted: function(n) {
                            if (!this._ignore) {
                                if (this._storeTaskCommand(n, t._undo.command.type.remove), this._nestedTasks[n.id])
                                    for (var e = this._nestedTasks[n.id], o = 0; o < e.length; o++) this._storeTaskCommand(e[o], t._undo.command.type.remove);
                                if (this._nestedLinks[n.id])
                                    for (var i = this._nestedLinks[n.id], o = 0; o < i.length; o++) this._storeLinkCommand(i[o], t._undo.command.type.remove)
                            }
                        },
                        onLinkAdded: function(n) {
                            this._ignore || this._storeLinkCommand(n, t._undo.command.type.add)
                        },
                        onLinkUpdated: function(n) {
                            this._ignore || this._storeLinkCommand(n, t._undo.command.type.update)
                        },
                        onLinkDeleted: function(n) {
                            this._ignore || this._storeLinkCommand(n, t._undo.command.type.remove)
                        },
                        _initialTasks: {},
                        _nestedTasks: {},
                        _nestedLinks: {},
                        _getLinks: function(t) {
                            return t.$source.concat(t.$target)
                        },
                        setNestedTasks: function(n, e) {
                            for (var o = null, i = [], a = this._getLinks(t.getTask(n)), s = 0; s < e.length; s++) o = this.setInitialTask(e[s]), a = a.concat(this._getLinks(o)), i.push(o);
                            for (var d = {}, s = 0; s < a.length; s++) d[a[s]] = !0;
                            var c = [];
                            for (var s in d) c.push(this.setInitialLink(s));
                            this._nestedTasks[n] = i, this._nestedLinks[n] = c
                        },
                        setInitialTask: function(n) {
                            if (!this._initialTasks[n] || !this._batchMode) {
                                var e = t.copy(t.getTask(n));
                                e.$index = t.getTaskIndex(n), this._initialTasks[n] = e
                            }
                            return this._initialTasks[n]
                        },
                        getInitialTask: function(t) {
                            return this._initialTasks[t]
                        },
                        _initialLinks: {},
                        setInitialLink: function(n) {
                            return this._initialLinks[n] && this._batchMode || (this._initialLinks[n] = t.copy(t.getLink(n))), this._initialLinks[n]
                        },
                        getInitialLink: function(t) {
                            return this._initialLinks[t]
                        }
                    }
                }, t._undo.updateConfigs = function() {
                    t._undo.maxSteps = t.config.undo_steps, t._undo.command.entity = t.config.undo_types, t._undo.command.type = t.config.undo_actions, t._undo.undo_enabled = !!t.config.undo, t._undo.redo_enabled = !!t.config.undo && !!t.config.redo
                },
                function() {
                    function n(t) {
                        return c.setInitialTask(t), !0
                    }

                    function e(t, n, e) {
                        t && (t.id == n && (t.id = e), t.parent == n && (t.parent = e))
                    }

                    function o(t, n, o) {
                        e(t.value, n, o), e(t.oldValue, n, o)
                    }

                    function i(t, n, e) {
                        t && (t.source == n && (t.source = e), t.target == n && (t.target = e))
                    }

                    function a(t, n, e) {
                        i(t.value, n, e), i(t.oldValue, n, e)
                    }

                    function s(n, e, i) {
                        for (var s = t._undo, d = 0; d < n.length; d++)
                            for (var c = n[d], u = 0; u < c.commands.length; u++) c.commands[u].entity == s.command.entity.task ? o(c.commands[u], e, i) : c.commands[u].entity == s.command.entity.link && a(c.commands[u], e, i)
                    }

                    function d(n, e, o) {
                        for (var i = t._undo, a = 0; a < n.length; a++)
                            for (var s = n[a], d = 0; d < s.commands.length; d++) {
                                var c = s.commands[d];
                                c.entity == i.command.entity.link && (c.value && c.value.id == e && (c.value.id = o), c.oldValue && c.oldValue.id == e && (c.oldValue.id = o))
                            }
                    }
                    var c = t._undo.monitor,
                        u = {
                            onBeforeUndo: "onAfterUndo",
                            onBeforeRedo: "onAfterRedo"
                        };
                    for (var r in u) t.attachEvent(r, function() {
                        c.startIgnore()
                    }), t.attachEvent(u[r], function() {
                        c.stopIgnore()
                    });
                    for (var h = ["onTaskDragStart", "onAfterTaskDelete", "onBeforeBatchUpdate"], r = 0; r < h.length; r++) t.attachEvent(h[r], function() {
                        c.startBatchAction()
                    });
                    t.attachEvent("onBeforeTaskDrag", n), t.attachEvent("onLightbox", n), t.attachEvent("onBeforeTaskAutoSchedule", function(t) {
                        return n(t.id), !0
                    }), t.attachEvent("onBeforeTaskDelete", function(e) {
                        n(e);
                        var o = [];
                        return t.eachTask(function(t) {
                            o.push(t.id)
                        }, e), c.setNestedTasks(e, o), !0
                    }), t.attachEvent("onAfterTaskAdd", function(t, n) {
                        c.onTaskAdded(n)
                    }), t.attachEvent("onAfterTaskUpdate", function(t, n) {
                        c.onTaskUpdated(n)
                    }), t.attachEvent("onAfterTaskDelete", function(t, n) {
                        c.onTaskDeleted(n)
                    }), t.attachEvent("onAfterLinkAdd", function(t, n) {
                        c.onLinkAdded(n)
                    }), t.attachEvent("onAfterLinkUpdate", function(t, n) {
                        c.onLinkUpdated(n)
                    }), t.attachEvent("onAfterLinkDelete", function(t, n) {
                        c.onLinkDeleted(n)
                    }), t.attachEvent("onTaskIdChange", function(n, e) {
                        var o = t._undo;
                        s(o._undoStack, n, e), s(o._redoStack, n, e)
                    }), t.attachEvent("onLinkIdChange", function(n, e) {
                        var o = t._undo;
                        d(o._undoStack, n, e), d(o._redoStack, n, e)
                    }), t.attachEvent("onGanttReady", function() {
                        t._undo.updateConfigs()
                    })
                }()
        }
    })
});
//# sourceMappingURL=dhtmlxgantt_undo.js.map