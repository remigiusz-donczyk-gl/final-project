(window.webpackJsonp=window.webpackJsonp||[]).push([[350],{2154:function(t,n,e){"use strict";e.r(n);var o,r=e(13),i=e(986),c=e(717),p=(o=function(t,n){return(o=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var e in n)Object.prototype.hasOwnProperty.call(n,e)&&(t[e]=n[e])})(t,n)},function(t,n){function e(){this.constructor=t}o(t,n),t.prototype=null===n?Object.create(n):(e.prototype=n.prototype,new e)}),a=function(t,n){var e={};for(var o in t)Object.prototype.hasOwnProperty.call(t,o)&&n.indexOf(o)<0&&(e[o]=t[o]);if(null!=t&&"function"==typeof Object.getOwnPropertySymbols){var r=0;for(o=Object.getOwnPropertySymbols(t);r<o.length;r++)n.indexOf(o[r])<0&&Object.prototype.propertyIsEnumerable.call(t,o[r])&&(e[o[r]]=t[o[r]])}return e},u=function(t){function n(){return null!==t&&t.apply(this,arguments)||this}return p(n,t),n.prototype.componentDidMount=function(){this.checkPermissions()},n.prototype.componentDidUpdate=function(){this.checkPermissions()},n.prototype.checkPermissions=function(){this.isProjectAdmin()||Object(i.a)()},n.prototype.isProjectAdmin=function(){var t=this.props.component.configuration;return null!=t&&t.showSettings},n.prototype.render=function(){if(!this.isProjectAdmin())return null;var t=this.props,n=t.children,e=a(t,["children"]);return r.createElement(r.Fragment,null,r.createElement(c.a,{anchor:"admin_main"}),r.cloneElement(n,e))},n}(r.PureComponent);n.default=u},717:function(t,n,e){"use strict";e.d(n,"a",(function(){return u}));var o,r=e(13),i=e(176),c=e(781),p=(o=function(t,n){return(o=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var e in n)Object.prototype.hasOwnProperty.call(n,e)&&(t[e]=n[e])})(t,n)},function(t,n){function e(){this.constructor=t}o(t,n),t.prototype=null===n?Object.create(n):(e.prototype=n.prototype,new e)}),a=function(){return(a=Object.assign||function(t){for(var n,e=1,o=arguments.length;e<o;e++)for(var r in n=arguments[e])Object.prototype.hasOwnProperty.call(n,r)&&(t[r]=n[r]);return t}).apply(this,arguments)};function u(t){return r.createElement(c.a.Consumer,null,(function(n){var e=n.addA11ySkipLink,o=n.removeA11ySkipLink;return r.createElement(s,a({addA11ySkipLink:e,removeA11ySkipLink:o},t))}))}var s=function(t){function n(){var n=null!==t&&t.apply(this,arguments)||this;return n.getLink=function(){var t=n.props,e=t.anchor,o=t.label;return{key:e,label:void 0===o?Object(i.translate)("skip_to_content"):o,weight:t.weight}},n}return p(n,t),n.prototype.componentDidMount=function(){this.props.addA11ySkipLink(this.getLink())},n.prototype.componentWillUnmount=function(){this.props.removeA11ySkipLink(this.getLink())},n.prototype.render=function(){var t=this.props.anchor;return r.createElement("span",{id:"a11y_target__"+t})},n}(r.PureComponent)},986:function(t,n,e){"use strict";e.d(n,"a",(function(){return p}));var o=e(181),r=e.n(o),i=e(907),c=e(763);function p(){var t=Object(c.default)(),n=r()(),e=window.location.pathname+window.location.search+window.location.hash;t.dispatch(Object(i.c)()),n.replace({pathname:"/sessions/new",query:{return_to:e}})}}}]);
//# sourceMappingURL=350.1655372229846.chunk.js.map