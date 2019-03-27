;
// Custom Event Polyfill
(function() {
    if (typeof window.CustomEvent === "function") return false

    function CustomEvent(event, params) {
        params = params || {
            bubbles: false,
            cancelable: false,
            detail: undefined
        }
        var evt = document.createEvent("CustomEvent")
        evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail)
        return evt
    }

    CustomEvent.prototype = window.Event.prototype

    window.CustomEvent = CustomEvent
})();
// Canvi Code
var _extends = Object.assign || function(t) {
        for (var n = 1; n < arguments.length; n++) {
            var i = arguments[n];
            for (var e in i) Object.prototype.hasOwnProperty.call(i, e) && (t[e] = i[e])
        }
        return t
    },
    _createClass = function() {
        function e(t, n) {
            for (var i = 0; i < n.length; i++) {
                var e = n[i];
                e.enumerable = e.enumerable || !1, e.configurable = !0, "value" in e && (e.writable = !0), Object.defineProperty(t, e.key, e)
            }
        }
        return function(t, n, i) {
            return n && e(t.prototype, n), i && e(t, i), t
        }
    }();

function _classCallCheck(t, n) {
    if (!(t instanceof n)) throw new TypeError("Cannot call a class as a function")
}
var Canvi = function() {
    function n() {
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
        _classCallCheck(this, n), this.options = _extends({
            speed: "0.3s",
            width: "300px",
            isDebug: !1,
            position: "left",
            pushContent: !0,
            navbar: ".canvi-navbar",
            content: ".canvi-content",
            openButton: ".canvi-open-button"
        }, t), this.isOpen = !1, this.body = document.querySelector("body"), this.transitionEvent = this._whichTransitionEvent(), this.navbar = document.querySelector(this.options.navbar), this.content = document.querySelector(this.options.content), this.openButton = document.querySelector(this.options.openButton), this.init()
    }
    return _createClass(n, [{
        key: "init",
        value: function() {
            this.options.isDebug && (console.log("%c %s", "color: #e01a51; font-style: italic;", "CANVI: Init is running..."), this._objectLog()), this._buildMarkup(), this._initializeMainEvents(), this._triggerCanviEvent("canvi.init"), this.navbar.setAttribute("inert", ""), this.navbar.setAttribute("aria-hidden", "true")
        }
    }, {
        key: "open",
        value: function() {
            var n = this;
            this.isOpen || (this.options.isDebug && console.log("%c %s", "color: #e01a51; font-style: italic;", "CANVI: Open is running..."), this._triggerCanviEvent("canvi.before-open"), this._buildOverlay(), this._setZindex(), this.content.classList.add("is-canvi-open"), this.body.classList.add("is-canvi-open"), this.navbar.classList.add("is-canvi-open"), this._responsiveWidth(), (this.options.pushContent ? this.content : this.navbar).addEventListener(this.transitionEvent, function(t) {
                return n._transtionOpenEnd(t)
            }), this.navbar.removeAttribute("inert"), this.navbar.removeAttribute("aria-hidden"), this.isOpen = !0)
        }
    }, {
        key: "close",
        value: function() {
            var n = this;
            this.isOpen && (this.options.isDebug && console.log("%c %s", "color: #e01a51; font-style: italic;", "CANVI: Close is running..."), this._triggerCanviEvent("canvi.before-close"), this.overlay.classList.add("canvi-animate-out"), this.content.style.transform = "translateX(0)", this.body.classList.remove("is-canvi-open"), this.navbar.classList.remove("is-canvi-open"), (this.options.pushContent ? this.content : this.navbar).addEventListener(this.transitionEvent, function(t) {
                return n._transitionCloseEnd(t)
            }), this.navbar.setAttribute("inert", ""), this.navbar.setAttribute("aria-hidden", "true"), this.isOpen = !1)
        }
    }, {
        key: "toggle",
        value: function() {
            this.options.isDebug && console.log("%c %s", "color: #e01a51; font-style: italic;", "CANVI: Toggle is running..."), this.isOpen ? this.close() : this.open()
        }
    }, {
        key: "_buildMarkup",
        value: function() {
            this.options.isDebug && console.log("%c %s", "color: #ccc; font-style: italic;", "CANVI: Build markup..."), this.options.position && (this.navbar.setAttribute("data-position", this.options.position), this.navbar.setAttribute("data-push-content", this.options.pushContent)), this.navbar.style.width = this.options.width, this.body.classList.add("is-canvi-ready")
        }
    }, {
        key: "_responsiveWidth",
        value: function() {
            var n = this;
            this.navbar.classList.contains("is-canvi-open") && window.matchMedia("(min-width: 0px)").matches && (this.navbar.style.width = this.options.width, this._responsiveWidthHelper(this.options.width)), this.navbar.classList.contains("is-canvi-open") && Array.isArray(this.options.responsiveWidths) && -1 < this.options.responsiveWidths.length && this.options.responsiveWidths.forEach(function(t) {
                window.matchMedia("(min-width: " + t.breakpoint + ")").matches && (n.navbar.style.width = t.width, n._responsiveWidthHelper(t.width))
            })
        }
    }, {
        key: "_responsiveWidthHelper",
        value: function(t) {
            this.options.pushContent && (this.content.style.transform = "left" === this.options.position ? "translateX(" + t + ")" : "translateX(-" + t + ")")
        }
    }, {
        key: "_buildOverlay",
        value: function() {
            var t = this;
            this.options.isDebug && console.log("%c %s", "color: #32da94; font-style: italic;", "CANVI: Build overlay..."), this.content.querySelector(".canvi-overlay") || (console.log("create canvi overlay"), this.overlay = document.createElement("div"), this.overlay.className = "canvi-overlay", this.content.appendChild(this.overlay)), this.overlay.addEventListener("click", function() {
                return t.close()
            }), this._setTransitionSpeed()
        }
    }, {
        key: "_removeOverlay",
        value: function() {
            var t = this;
            this.options.isDebug && console.log("%c %s", "color: #32da94; font-style: italic;", "CANVI: Remove overlay..."), this.overlay && (this.content.removeChild(this.overlay), this.overlay.removeEventListener("click", function() {
                return t.open()
            }))
        }
    }, {
        key: "_initializeMainEvents",
        value: function() {
            var n = this;
            this.options.isDebug && (console.log("%c %s", "color: #ccc; font-style: italic;", "CANVI: Init main events..."), console.log("%c %s", "color: #999; font-style: italic;", "---------")), this.body.addEventListener("keyup", function(t) {
                n.isOpen && 27 == t.keyCode && n.close()
            }), this.openButton && this.openButton.addEventListener("click", function() {
                return n.open()
            }), window.addEventListener("resize", function() {
                return n._responsiveWidth()
            })
        }
    }, {
        key: "_transtionOpenEnd",
        value: function(t) {
            var n = this;
            this.isOpen && "transform" === t.propertyName && (this.options.isDebug && (console.log("%c %s", "color: #ff7600; font-style: italic;", "CANVI: Open transition end..."), console.log("%c %s", "color: #999; font-style: italic;", "---------")), this._triggerCanviEvent("canvi.after-open"), (this.options.pushContent ? this.content : this.navbar).removeEventListener(this.transitionEvent, function(t) {
                return n._transtionOpenEnd(t)
            }))
        }
    }, {
        key: "_transitionCloseEnd",
        value: function(t) {
            var n = this;
            this.isOpen || "transform" !== t.propertyName || (this.options.isDebug && console.log("%c %s", "color: #ff7600; font-style: italic;", "CANVI: Close transition end..."), this._triggerCanviEvent("canvi.after-close"), this._removeOverlay(), this._resetZindex(), (this.options.pushContent ? this.content : this.navbar).removeEventListener(this.transitionEvent, function(t) {
                return n._transitionCloseEnd(t)
            }), this.content.classList.remove("is-canvi-open"))
        }
    }, {
        key: "_setTransitionSpeed",
        value: function() {
            this.navbar.style.transitionDuration = this.options.speed, this.content.style.transitionDuration = this.options.speed, this.overlay.style.animationDuration = this.options.speed
        }
    }, {
        key: "_setZindex",
        value: function() {
            this.navbar.style.zIndex = this.options.pushContent ? 20 : 10, this.content.style.zIndex = this.options.pushContent ? 40 : 5
        }
    }, {
        key: "_resetZindex",
        value: function() {
            this.navbar.style.zIndex = 1, this.content.style.zIndex = 5
        }
    }, {
        key: "_whichTransitionEvent",
        value: function() {
            var t = document.createElement("fakeelement"),
                n = {
                    transition: "transitionend",
                    OTransition: "oTransitionEnd",
                    MozTransition: "transitionend",
                    WebkitTransition: "webkitTransitionEnd"
                };
            for (var i in n)
                if (void 0 !== t.style[i]) return n[i]
        }
    }, {
        key: "_triggerCanviEvent",
        value: function(t) {
            this.body.dispatchEvent(new CustomEvent(t, {
                details: {
                    navbar: this.navbar,
                    openButton: this.openButton,
                    content: this.content
                }
            }))
        }
    }, {
        key: "_objectLog",
        value: function() {
            console.groupCollapsed("Canvi Object"), console.log("Open Button: ", this.openButton), console.log("Navbar: ", this.navbar), console.log("Content: ", this.content), console.groupEnd()
        }
    }]), n
}();
