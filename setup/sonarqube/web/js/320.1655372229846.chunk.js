(window.webpackJsonp=window.webpackJsonp||[]).push([[320],{1771:function(t,n,e){var r=e(662),i=e(1772);"string"==typeof(i=i.__esModule?i.default:i)&&(i=[[t.i,i,""]]);var c={insert:"head",singleton:!1},o=(r(i,c),i.locals?i.locals:{});t.exports=o},1772:function(t,n,e){(n=e(663)(!1)).push([t.i,".plugin-risk-consent-page{padding-top:10vh}.plugin-risk-consent-page h1{line-height:1.5;font-size:24px;font-weight:300;text-align:center}.plugin-risk-consent-content{min-width:500px;width:40%;margin:0 auto}",""]),t.exports=n},2162:function(t,n,e){"use strict";e.r(n),e.d(n,"PluginRiskConsent",(function(){return g}));var r=e(13),i=e(661),c=e(176),o=e(800),u=e(988),s=e(716),a=e(702),l=e(1021),p=e(866),f=e(916),d=e(1020),b=(e(1771),function(t,n,e,r){return new(e||(e=Promise))((function(i,c){function o(t){try{s(r.next(t))}catch(t){c(t)}}function u(t){try{s(r.throw(t))}catch(t){c(t)}}function s(t){var n;t.done?i(t.value):(n=t.value,n instanceof e?n:new e((function(t){t(n)}))).then(o,u)}s((r=r.apply(t,n||[])).next())}))}),h=function(t,n){var e,r,i,c,o={label:0,sent:function(){if(1&i[0])throw i[1];return i[1]},trys:[],ops:[]};return c={next:u(0),throw:u(1),return:u(2)},"function"==typeof Symbol&&(c[Symbol.iterator]=function(){return this}),c;function u(c){return function(u){return function(c){if(e)throw new TypeError("Generator is already executing.");for(;o;)try{if(e=1,r&&(i=2&c[0]?r.return:c[0]?r.throw||((i=r.return)&&i.call(r),0):r.next)&&!(i=i.call(r,c[1])).done)return i;switch(r=0,i&&(c=[2&c[0],i.value]),c[0]){case 0:case 1:i=c;break;case 4:return o.label++,{value:c[1],done:!1};case 5:o.label++,r=c[1],c=[0];continue;case 7:c=o.ops.pop(),o.trys.pop();continue;default:if(!(i=(i=o.trys).length>0&&i[i.length-1])&&(6===c[0]||2===c[0])){o=0;continue}if(3===c[0]&&(!i||c[1]>i[0]&&c[1]<i[3])){o.label=c[1];break}if(6===c[0]&&o.label<i[1]){o.label=i[1],i=c;break}if(i&&o.label<i[2]){o.label=i[2],o.ops.push(c);break}i[2]&&o.ops.pop(),o.trys.pop();continue}c=n.call(t,o)}catch(t){c=[6,t],r=0}finally{e=i=0}if(5&c[0])throw c[1];return{value:c[0]?c[1]:void 0,done:!0}}([c,u])}}};function g(t){var n=this,e=t.router,u=t.currentUser;if(!Object(a.a)(u,l.a.Admin))return e.replace("/"),null;return r.createElement("div",{className:"plugin-risk-consent-page"},r.createElement(d.a,null),r.createElement("div",{className:"plugin-risk-consent-content boxed-group"},r.createElement("div",{className:"boxed-group-inner text-center"},r.createElement("h1",{className:"big-spacer-bottom"},Object(c.translate)("plugin_risk_consent.title")),r.createElement("p",{className:"big big-spacer-bottom"},Object(c.translate)("plugin_risk_consent.description")),r.createElement("p",{className:"big huge-spacer-bottom"},Object(c.translate)("plugin_risk_consent.description2")),r.createElement(i.Button,{className:"big-spacer-bottom",onClick:function(){return b(n,void 0,void 0,(function(){return h(this,(function(t){switch(t.label){case 0:return t.trys.push([0,2,,3]),[4,Object(o.i)({key:f.a.PluginRiskConsent,value:p.b.Accepted})];case 1:return t.sent(),window.location.href="/",[3,3];case 2:return t.sent(),[3,3];case 3:return[2]}}))}))}},Object(c.translate)("plugin_risk_consent.action")))))}n.default=Object(u.a)(Object(s.a)(g))},770:function(t,n,e){var r=e(685),i=e(678),c=e(861),o=e(863);t.exports=function(t,n){if(null==t)return{};var e=r(o(t),(function(t){return[t]}));return n=i(n),c(t,e,(function(t,e){return n(t,e[0])}))}},786:function(t,n,e){var r=e(678),i=e(787),c=e(770);t.exports=function(t,n){return c(t,i(r(n)))}},787:function(t,n){t.exports=function(t){if("function"!=typeof t)throw new TypeError("Expected a function");return function(){var n=arguments;switch(n.length){case 0:return!t.call(this);case 1:return!t.call(this,n[0]);case 2:return!t.call(this,n[0],n[1]);case 3:return!t.call(this,n[0],n[1],n[2])}return!t.apply(this,n)}}},800:function(t,n,e){"use strict";e.d(n,"d",(function(){return s})),e.d(n,"e",(function(){return a})),e.d(n,"h",(function(){return l})),e.d(n,"i",(function(){return p})),e.d(n,"f",(function(){return f})),e.d(n,"g",(function(){return d})),e.d(n,"a",(function(){return b})),e.d(n,"c",(function(){return h})),e.d(n,"b",(function(){return g}));var r=e(786),i=e.n(r),c=e(49),o=e(673),u=e(780);function s(t){return Object(c.getJSON)("/api/settings/list_definitions",{component:t}).then((function(t){return t.definitions}),o.a)}function a(t){return Object(c.getJSON)("/api/settings/values",t).then((function(t){return t.settings}))}function l(t,n,e){var r={key:t.key,component:e};return Object(u.k)(t)&&t.multiValues?r.values=n:"PROPERTY_SET"===t.type?r.fieldValues=n.map((function(t){return i()(t,(function(t){return null==t}))})).map(JSON.stringify):r.value=n,Object(c.post)("/api/settings/set",r)}function p(t){return Object(c.post)("/api/settings/set",t).catch(o.a)}function f(t){return Object(c.post)("/api/settings/reset",t)}function d(t,n,e){return Object(c.post)("/api/emails/send",{to:t,subject:n,message:e})}function b(){return Object(c.getJSON)("/api/settings/check_secret_key").catch(o.a)}function h(){return Object(c.postJSON)("/api/settings/generate_secret_key").catch(o.a)}function g(t){return Object(c.postJSON)("/api/settings/encrypt",{value:t}).catch(o.a)}},866:function(t,n,e){"use strict";var r,i;function c(t){return void 0!==t.release}function o(t){return function(t){return void 0!==t.version}(t)&&void 0!==t.updatedAt}e.d(n,"a",(function(){return r})),e.d(n,"b",(function(){return i})),e.d(n,"c",(function(){return c})),e.d(n,"d",(function(){return o})),function(t){t.Bundled="BUNDLED",t.External="EXTERNAL"}(r||(r={})),function(t){t.Accepted="ACCEPTED",t.NotAccepted="NOT_ACCEPTED",t.Required="REQUIRED"}(i||(i={}))},916:function(t,n,e){"use strict";var r;e.d(n,"a",(function(){return r})),function(t){t.DaysBeforeDeletingInactiveBranchesAndPRs="sonar.dbcleaner.daysBeforeDeletingInactiveBranchesAndPRs",t.DefaultProjectVisibility="projects.default.visibility",t.ServerBaseUrl="sonar.core.serverBaseURL",t.PluginRiskConsent="sonar.plugins.risk.consent"}(r||(r={}))},988:function(t,n,e){"use strict";e.d(n,"a",(function(){return f}));var r,i=e(13),c=e(180),o=e.n(c),u=e(702),s=e(875),a=e(773),l=(r=function(t,n){return(r=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var e in n)Object.prototype.hasOwnProperty.call(n,e)&&(t[e]=n[e])})(t,n)},function(t,n){function e(){this.constructor=t}r(t,n),t.prototype=null===n?Object.create(n):(e.prototype=n.prototype,new e)}),p=function(){return(p=Object.assign||function(t){for(var n,e=1,r=arguments.length;e<r;e++)for(var i in n=arguments[e])Object.prototype.hasOwnProperty.call(n,i)&&(t[i]=n[i]);return t}).apply(this,arguments)};function f(t){var n=function(n){function e(){return null!==n&&n.apply(this,arguments)||this}return l(e,n),e.prototype.componentDidMount=function(){Object(u.b)(this.props.currentUser)||o()()},e.prototype.render=function(){return Object(u.b)(this.props.currentUser)?i.createElement(t,p({},this.props)):null},e.displayName=Object(s.a)(t,"whenLoggedIn"),e}(i.Component);return Object(a.a)(n)}}}]);
//# sourceMappingURL=320.1655372229846.chunk.js.map