(window.webpackJsonp=window.webpackJsonp||[]).push([[294],{1049:function(t,e,n){"use strict";var r=this&&this.__assign||function(){return(r=Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++)for(var a in e=arguments[n])Object.prototype.hasOwnProperty.call(e,a)&&(t[a]=e[a]);return t}).apply(this,arguments)},a=this&&this.__rest||function(t,e){var n={};for(var r in t)Object.prototype.hasOwnProperty.call(t,r)&&e.indexOf(r)<0&&(n[r]=t[r]);if(null!=t&&"function"==typeof Object.getOwnPropertySymbols){var a=0;for(r=Object.getOwnPropertySymbols(t);a<r.length;a++)e.indexOf(r[a])<0&&Object.prototype.propertyIsEnumerable.call(t,r[a])&&(n[r[a]]=t[r[a]])}return n};Object.defineProperty(e,"__esModule",{value:!0});var o=n(660),i=n(13);n(1050),e.default=function(t){var e=t.children,n=t.className,s=a(t,["children","className"]);return i.createElement("ul",r({},s,{className:o("navbar-tabs",n)}),e)}},1050:function(t,e,n){var r=n(662),a=n(1051);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[t.i,a,""]]);var o={insert:"head",singleton:!1},i=(r(a,o),a.locals?a.locals:{});t.exports=i},1051:function(t,e,n){(e=n(663)(!1)).push([t.i,".navbar-tabs{display:flex;align-items:center;clear:left;height:24px;margin-top:8px}.navbar-tabs>li+li{margin-left:20px}.navbar-tabs>li>a{display:block;height:24px;line-height:16px;padding-top:2px;border-bottom:3px solid transparent;box-sizing:border-box;color:#333;transition:none}.navbar-tabs>li>a.active,.navbar-tabs>li>a:focus,.navbar-tabs>li>a:hover{border-bottom-color:#4b9fd5}",""]),t.exports=e},1080:function(t,e,n){"use strict";n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return o}));var r=n(13),a={installing:[],removing:[],updating:[]},o="UP",i=r.createContext({fetchSystemStatus:function(){},fetchPendingPlugins:function(){},pendingPlugins:a,systemStatus:o});e.a=i},1186:function(t,e,n){"use strict";var r=this&&this.__assign||function(){return(r=Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++)for(var a in e=arguments[n])Object.prototype.hasOwnProperty.call(e,a)&&(t[a]=e[a]);return t}).apply(this,arguments)},a=this&&this.__rest||function(t,e){var n={};for(var r in t)Object.prototype.hasOwnProperty.call(t,r)&&e.indexOf(r)<0&&(n[r]=t[r]);if(null!=t&&"function"==typeof Object.getOwnPropertySymbols){var a=0;for(r=Object.getOwnPropertySymbols(t);a<r.length;a++)e.indexOf(r[a])<0&&Object.prototype.propertyIsEnumerable.call(t,r[a])&&(n[r[a]]=t[r[a]])}return n};Object.defineProperty(e,"__esModule",{value:!0});var o=n(660),i=n(13);n(1187);var s=n(864);e.default=function(t){var e=t.className,n=a(t,["className"]);return i.createElement(s.default,r({className:o("navbar-context",e)},n))}},1187:function(t,e,n){var r=n(662),a=n(1188);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[t.i,a,""]]);var o={insert:"head",singleton:!1},i=(r(a,o),a.locals?a.locals:{});t.exports=i},1188:function(t,e,n){(e=n(663)(!1)).push([t.i,".navbar-context,.navbar-context .navbar-inner{background-color:#fff;z-index:420}.navbar-context .navbar-inner{padding-top:8px;border-bottom:1px solid #e6e6e6}.navbar-context .navbar-inner-with-notif{border-bottom:none}.navbar-context-justified{display:flex;justify-content:space-between}.navbar-context-header{display:flex;align-items:center;min-width:0;height:32px;font-size:16px}.navbar-context-header>:not(.navbar-context-header-breadcrumb-link){flex-shrink:0}.navbar-context-header-breadcrumb-link{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.navbar-context-header .slash-separator{margin-left:8px;margin-right:8px;font-size:24px}.navbar-context-header .slash-separator:after{color:rgba(68,68,68,.2)}.navbar-context-meta{display:flex;align-items:center;height:32px;padding-left:20px;color:#666;font-size:12px;text-align:right}.navbar-context-meta-secondary{position:absolute;top:34px;right:0;padding:0 20px;white-space:nowrap}.navbar-context-description{display:inline-block;line-height:24px;margin-left:8px;padding-top:4px;color:#666;font-size:12px}",""]),t.exports=e},1208:function(t,e,n){"use strict";var r,a=n(660),o=n(13),i=n(661),s=n(742),c=n.n(s),u=n(176),l=n(884),p=(r=function(t,e){return(r=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n])})(t,e)},function(t,e){function n(){this.constructor=t}r(t,e),t.prototype=null===e?Object.create(e):(n.prototype=e.prototype,new n)}),f=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.handleConfirm=function(){return Object(l.f)().then(e.props.fetchSystemStatus)},e}return p(e,t),e.prototype.render=function(){var t=this.props,e=t.className,n=t.systemStatus;return o.createElement(c.a,{confirmButtonText:Object(u.translate)("restart"),modalBody:o.createElement(o.Fragment,null,o.createElement("p",{className:"spacer-top spacer-bottom"},Object(u.translate)("system.are_you_sure_to_restart")),o.createElement("p",null,Object(u.translate)("system.forcing_shutdown_not_recommended"))),modalHeader:Object(u.translate)("system.restart_server"),onConfirm:this.handleConfirm},(function(t){var r=t.onClick;return o.createElement(i.Button,{className:a("button-red",e),disabled:"UP"!==n,onClick:r},"RESTARTING"===n?Object(u.translate)("system.restart_in_progress"):Object(u.translate)("system.restart_server"))}))},e}(o.PureComponent);e.a=f},2214:function(t,e,n){"use strict";n.r(e),n.d(e,"AdminContainer",(function(){return F}));var r,a=n(13),o=n(684),i=n(674),s=n(176),c=n(911),u=n(987),l=n(884),p=n(986),f=n(907),m=n(676),d=n(1080),h=n(660),b=n(667),g=n(675),v=n.n(g),y=n(683),O=n.n(y),_=n(1186),j=n.n(_),S=n(1049),E=n.n(S),x=n(687),P=n(698),C=n(665),w=n(661),N=n(671),k=n(829),A=n(1208),T=(r=function(t,e){return(r=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n])})(t,e)},function(t,e){function n(){this.constructor=t}r(t,e),t.prototype=null===e?Object.create(e):(n.prototype=e.prototype,new n)}),M=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.handleRevert=function(){Object(u.a)().then(e.props.refreshPending,(function(){}))},e}return T(e,t),e.prototype.render=function(){var t=this.props.pending,e=t.installing,n=t.updating,r=t.removing;return e.length||n.length||r.length?a.createElement(N.Alert,{className:"js-pending",display:"banner",variant:"info"},a.createElement("div",{className:"display-flex-center"},a.createElement("span",{className:"little-spacer-right"},a.createElement(k.a,{message:Object(s.translate)("marketplace.instance_needs_to_be_restarted_to")})),[{length:e.length,msg:"marketplace.install_x_plugins"},{length:n.length,msg:"marketplace.update_x_plugins"},{length:r.length,msg:"marketplace.uninstall_x_plugins"}].filter((function(t){return t.length>0})).map((function(t,e){var n=t.length,r=t.msg;return a.createElement("span",{key:r},e>0&&"; ",a.createElement(C.FormattedMessage,{defaultMessage:Object(s.translate)(r),id:r,values:{nb:a.createElement("strong",null,n)}}))})),a.createElement(A.a,{className:"spacer-left",fetchSystemStatus:this.props.fetchSystemStatus,systemStatus:this.props.systemStatus}),a.createElement(w.Button,{className:"spacer-left js-cancel-all",onClick:this.handleRevert},Object(s.translate)("marketplace.revert")))):null},e}(a.PureComponent),D=n(38);function R(){return a.createElement(N.Alert,{display:"banner",variant:"info"},a.createElement(C.FormattedMessage,{defaultMessage:Object(s.translate)("system.instance_restarting"),id:"system.instance_restarting",values:{instance:Object(D.getInstance)(),link:a.createElement(b.c,{to:{pathname:"/admin/background_tasks"}},Object(s.translate)("background_tasks.page"))}}))}var B=function(){var t=function(e,n){return(t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n])})(e,n)};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}(),U=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.renderExtension=function(t){var e=t.key,n=t.name;return a.createElement("li",{key:e},a.createElement(b.c,{activeClassName:"active",to:"/admin/extension/"+e},n))},e}return B(e,t),e.prototype.isSomethingActive=function(t){var e=window.location.pathname;return t.some((function(t){return 0===e.indexOf(Object(x.getBaseUrl)()+t)}))},e.prototype.isSecurityActive=function(){return this.isSomethingActive(["/admin/users","/admin/groups","/admin/permissions","/admin/permission_templates"])},e.prototype.isProjectsActive=function(){return this.isSomethingActive(["/admin/projects_management","/admin/background_tasks"])},e.prototype.isSystemActive=function(){return this.isSomethingActive(["/admin/system"])},e.prototype.isMarketplace=function(){return this.isSomethingActive(["/admin/marketplace"])},e.prototype.renderConfigurationTab=function(){var t=this,e=this.props.extensions.filter((function(t){return"license/support"!==t.key}));return a.createElement(v.a,{overlay:a.createElement("ul",{className:"menu"},a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/settings"},Object(s.translate)("settings.page"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/settings/encryption"},Object(s.translate)("property.category.security.encryption"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/custom_metrics"},Object(s.translate)("custom_metrics.page"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/webhooks"},Object(s.translate)("webhooks.page"))),e.map(this.renderExtension)),tagName:"li"},(function(e){var n=e.onToggleClick,r=e.open;return a.createElement("a",{"aria-expanded":r,"aria-haspopup":"menu",role:"button",className:h("dropdown-toggle",{active:r||!t.isSecurityActive()&&!t.isProjectsActive()&&!t.isSystemActive()&&!t.isSomethingActive(["/admin/extension/license/support"])&&!t.isMarketplace()}),href:"#",id:"settings-navigation-configuration",onClick:n},Object(s.translate)("sidebar.project_settings"),a.createElement(O.a,{className:"little-spacer-left"}))}))},e.prototype.renderProjectsTab=function(){var t=this;return a.createElement(v.a,{overlay:a.createElement("ul",{className:"menu"},a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/projects_management"},Object(s.translate)("management"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/background_tasks"},Object(s.translate)("background_tasks.page")))),tagName:"li"},(function(e){var n=e.onToggleClick,r=e.open;return a.createElement("a",{"aria-expanded":r,"aria-haspopup":"menu",role:"button",className:h("dropdown-toggle",{active:r||t.isProjectsActive()}),href:"#",onClick:n},Object(s.translate)("sidebar.projects"),a.createElement(O.a,{className:"little-spacer-left"}))}))},e.prototype.renderSecurityTab=function(){var t=this;return a.createElement(v.a,{overlay:a.createElement("ul",{className:"menu"},a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/users"},Object(s.translate)("users.page"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/groups"},Object(s.translate)("user_groups.page"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/permissions"},Object(s.translate)("global_permissions.page"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/permission_templates"},Object(s.translate)("permission_templates")))),tagName:"li"},(function(e){var n=e.onToggleClick,r=e.open;return a.createElement("a",{"aria-expanded":r,"aria-haspopup":"menu",role:"button",className:h("dropdown-toggle",{active:r||t.isSecurityActive()}),href:"#",onClick:n},Object(s.translate)("sidebar.security"),a.createElement(O.a,{className:"little-spacer-left"}))}))},e.prototype.render=function(){var t,e=this.props,n=e.extensions,r=e.pendingPlugins,o=n.find((function(t){return"license/support"===t.key})),i=r.installing.length+r.removing.length+r.updating.length,c=P.rawSizes.contextNavHeightRaw;return"RESTARTING"===this.props.systemStatus?t=a.createElement(R,null):i>0&&(t=a.createElement(M,{fetchSystemStatus:this.props.fetchSystemStatus,pending:r,refreshPending:this.props.fetchPendingPlugins,systemStatus:this.props.systemStatus})),a.createElement(j.a,{height:t?c+30:c,id:"context-navigation",notif:t},a.createElement("header",{className:"navbar-context-header"},a.createElement("h1",null,Object(s.translate)("layout.settings"))),a.createElement(E.a,null,this.renderConfigurationTab(),this.renderSecurityTab(),this.renderProjectsTab(),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/system"},Object(s.translate)("sidebar.system"))),a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/marketplace"},Object(s.translate)("marketplace.page"))),o&&a.createElement("li",null,a.createElement(b.a,{activeClassName:"active",to:"/admin/extension/license/support"},Object(s.translate)("support")))))},e.defaultProps={extensions:[]},e}(a.PureComponent),J=function(){var t=function(e,n){return(t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n])})(e,n)};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}(),F=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.mounted=!1,e.state={pendingPlugins:d.b,systemStatus:d.c},e.fetchNavigationSettings=function(){Object(c.c)().then((function(t){return e.props.setAdminPages(t.extensions)}),(function(){}))},e.fetchPendingPlugins=function(){Object(u.e)().then((function(t){e.mounted&&e.setState({pendingPlugins:t})}),(function(){}))},e.fetchSystemStatus=function(){Object(l.c)().then((function(t){var n=t.status;e.mounted&&(e.setState({systemStatus:n}),"RESTARTING"===n&&e.waitRestartingDone())}),(function(){}))},e.waitRestartingDone=function(){Object(l.h)().then((function(t){var n=t.status;e.mounted&&(e.setState({systemStatus:n}),document.location.reload())}),(function(){}))},e}return J(e,t),e.prototype.componentDidMount=function(){this.mounted=!0,this.props.appState.canAdmin?(this.fetchNavigationSettings(),this.fetchPendingPlugins(),this.fetchSystemStatus()):Object(p.a)()},e.prototype.componentWillUnmount=function(){this.mounted=!1},e.prototype.render=function(){var t=this.props.appState.adminPages;if(!t)return null;var e=this.state,n=e.pendingPlugins,r=e.systemStatus,i=Object(s.translate)("layout.settings");return a.createElement("div",null,a.createElement(o.a,{defaultTitle:i,defer:!1,titleTemplate:"%s - "+i}),a.createElement(U,{extensions:t,fetchPendingPlugins:this.fetchPendingPlugins,fetchSystemStatus:this.fetchSystemStatus,location:this.props.location,pendingPlugins:n,systemStatus:r}),a.createElement(d.a.Provider,{value:{fetchSystemStatus:this.fetchSystemStatus,fetchPendingPlugins:this.fetchPendingPlugins,pendingPlugins:n,systemStatus:r}},this.props.children))},e}(a.PureComponent),I={setAdminPages:f.d};e.default=Object(i.b)((function(t){return{appState:Object(m.getAppState)(t)}}),I)(F)},681:function(t,e,n){"use strict";var r,a=this&&this.__extends||(r=function(t,e){return(r=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])})(t,e)},function(t,e){function n(){this.constructor=t}r(t,e),t.prototype=null===e?Object.create(e):(n.prototype=e.prototype,new n)}),o=this&&this.__assign||function(){return(o=Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++)for(var a in e=arguments[n])Object.prototype.hasOwnProperty.call(e,a)&&(t[a]=e[a]);return t}).apply(this,arguments)},i=this&&this.__rest||function(t,e){var n={};for(var r in t)Object.prototype.hasOwnProperty.call(t,r)&&e.indexOf(r)<0&&(n[r]=t[r]);if(null!=t&&"function"==typeof Object.getOwnPropertySymbols){var a=0;for(r=Object.getOwnPropertySymbols(t);a<r.length;a++)e.indexOf(r[a])<0&&Object.prototype.propertyIsEnumerable.call(t,r[a])&&(n[r[a]]=t[r[a]])}return n};Object.defineProperty(e,"__esModule",{value:!0});var s=n(13),c=n(680),u=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.mounted=!1,e.state={submitting:!1},e.stopSubmitting=function(){e.mounted&&e.setState({submitting:!1})},e.handleCloseClick=function(t){t&&(t.preventDefault(),t.currentTarget.blur()),e.props.onClose()},e.handleFormSubmit=function(t){t.preventDefault(),e.submit()},e.handleSubmitClick=function(t){t&&(t.preventDefault(),t.currentTarget.blur()),e.submit()},e.submit=function(){var t=e.props.onSubmit();t&&(e.setState({submitting:!0}),t.then(e.stopSubmitting,e.stopSubmitting))},e}return a(e,t),e.prototype.componentDidMount=function(){this.mounted=!0},e.prototype.componentWillUnmount=function(){this.mounted=!1},e.prototype.render=function(){var t=this.props,e=t.children,n=t.header,r=t.onClose,a=(t.onSubmit,i(t,["children","header","onClose","onSubmit"]));return s.createElement(c.default,o({contentLabel:n,onRequestClose:r},a),e({onCloseClick:this.handleCloseClick,onFormSubmit:this.handleFormSubmit,onSubmitClick:this.handleSubmitClick,submitting:this.state.submitting}))},e}(s.Component);e.default=u},706:function(t,e,n){"use strict";var r,a=this&&this.__extends||(r=function(t,e){return(r=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])})(t,e)},function(t,e){function n(){this.constructor=t}r(t,e),t.prototype=null===e?Object.create(e):(n.prototype=e.prototype,new n)}),o=this&&this.__assign||function(){return(o=Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++)for(var a in e=arguments[n])Object.prototype.hasOwnProperty.call(e,a)&&(t[a]=e[a]);return t}).apply(this,arguments)};Object.defineProperty(e,"__esModule",{value:!0});var i=n(13),s=n(176),c=n(668),u=n(661),l=n(790),p=n(681),f=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.mounted=!1,e.handleSubmit=function(){var t=e.props.onConfirm(e.props.confirmData);return t?t.then(e.props.onClose,(function(){})):void e.props.onClose()},e.renderModalContent=function(t){var n=t.onCloseClick,r=t.onFormSubmit,a=t.submitting,o=e.props,p=o.children,f=o.confirmButtonText,m=o.confirmDisable,d=o.header,h=o.headerDescription,b=o.isDestructive,g=o.cancelButtonText,v=void 0===g?s.translate("cancel"):g;return i.createElement(l.default,null,i.createElement("form",{onSubmit:r},i.createElement("header",{className:"modal-head"},i.createElement("h2",null,d),h),i.createElement("div",{className:"modal-body"},p),i.createElement("footer",{className:"modal-foot"},i.createElement(c.default,{className:"spacer-right",loading:a}),i.createElement(u.SubmitButton,{autoFocus:!0,className:b?"button-red":void 0,disabled:a||m},f),i.createElement(u.ResetButtonLink,{disabled:a,onClick:n},v))))},e}return a(e,t),e.prototype.componentDidMount=function(){this.mounted=!0},e.prototype.componentWillUnmount=function(){this.mounted=!1},e.prototype.render=function(){var t=this.props,e={header:t.header,onClose:t.onClose,noBackdrop:t.noBackdrop,size:t.size};return i.createElement(p.default,o({onSubmit:this.handleSubmit},e),this.renderModalContent)},e}(i.PureComponent);e.default=f},710:function(t,e,n){var r=n(782);t.exports=function(t){return t?(t=r(t))===1/0||t===-1/0?17976931348623157e292*(t<0?-1:1):t==t?t:0:0===t?t:0}},736:function(t,e,n){var r=n(710);t.exports=function(t){var e=r(t),n=e%1;return e==e?n?e-n:e:0}},742:function(t,e,n){"use strict";var r,a=this&&this.__extends||(r=function(t,e){return(r=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])})(t,e)},function(t,e){function n(){this.constructor=t}r(t,e),t.prototype=null===e?Object.create(e):(n.prototype=e.prototype,new n)}),o=this&&this.__assign||function(){return(o=Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++)for(var a in e=arguments[n])Object.prototype.hasOwnProperty.call(e,a)&&(t[a]=e[a]);return t}).apply(this,arguments)},i=this&&this.__rest||function(t,e){var n={};for(var r in t)Object.prototype.hasOwnProperty.call(t,r)&&e.indexOf(r)<0&&(n[r]=t[r]);if(null!=t&&"function"==typeof Object.getOwnPropertySymbols){var a=0;for(r=Object.getOwnPropertySymbols(t);a<r.length;a++)e.indexOf(r[a])<0&&Object.prototype.propertyIsEnumerable.call(t,r[a])&&(n[r[a]]=t[r[a]])}return n};Object.defineProperty(e,"__esModule",{value:!0});var s=n(13),c=n(706),u=n(743),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.renderConfirmModal=function(t){var n=t.onClose,r=e.props,a=(r.children,r.modalBody),u=r.modalHeader,l=r.modalHeaderDescription,p=i(r,["children","modalBody","modalHeader","modalHeaderDescription"]);return s.createElement(c.default,o({header:u,headerDescription:l,onClose:n},p),a)},e}return a(e,t),e.prototype.render=function(){return s.createElement(u.default,{modal:this.renderConfirmModal},this.props.children)},e}(s.PureComponent);e.default=l},743:function(t,e,n){"use strict";var r,a=this&&this.__extends||(r=function(t,e){return(r=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])})(t,e)},function(t,e){function n(){this.constructor=t}r(t,e),t.prototype=null===e?Object.create(e):(n.prototype=e.prototype,new n)});Object.defineProperty(e,"__esModule",{value:!0});var o=n(13),i=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.mounted=!1,e.state={modal:!1},e.handleButtonClick=function(){e.setState({modal:!0})},e.handleFormSubmit=function(t){t&&t.preventDefault(),e.setState({modal:!0})},e.handleCloseModal=function(){e.mounted&&e.setState({modal:!1})},e}return a(e,t),e.prototype.componentDidMount=function(){this.mounted=!0},e.prototype.componentWillUnmount=function(){this.mounted=!1},e.prototype.render=function(){return o.createElement(o.Fragment,null,this.props.children({onClick:this.handleButtonClick,onFormSubmit:this.handleFormSubmit}),this.state.modal&&this.props.modal({onClose:this.handleCloseModal}))},e}(o.PureComponent);e.default=i},769:function(t,e){t.exports=function(t,e,n,r){for(var a=t.length,o=n+(r?1:-1);r?o--:++o<a;)if(e(t[o],o,t))return o;return-1}},866:function(t,e,n){"use strict";var r,a;function o(t){return void 0!==t.release}function i(t){return function(t){return void 0!==t.version}(t)&&void 0!==t.updatedAt}n.d(e,"a",(function(){return r})),n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return o})),n.d(e,"d",(function(){return i})),function(t){t.Bundled="BUNDLED",t.External="EXTERNAL"}(r||(r={})),function(t){t.Accepted="ACCEPTED",t.NotAccepted="NOT_ACCEPTED",t.Required="REQUIRED"}(a||(a={}))},884:function(t,e,n){"use strict";n.d(e,"g",(function(){return o})),n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return s})),n.d(e,"d",(function(){return c})),n.d(e,"a",(function(){return u})),n.d(e,"e",(function(){return l})),n.d(e,"f",(function(){return p})),n.d(e,"h",(function(){return f}));var r=n(49),a=n(673);function o(t){return Object(r.post)("/api/system/change_log_level",{level:t}).catch(a.a)}function i(){return Object(r.getJSON)("/api/system/info").catch(a.a)}function s(){return Object(r.getJSON)("/api/system/status")}function c(){return Object(r.getJSON)("/api/system/upgrades")}function u(){return Object(r.getJSON)("/api/system/db_migration_status")}function l(){return Object(r.postJSON)("/api/system/migrate_db")}function p(){return Object(r.post)("/api/system/restart").catch(a.a)}function f(){return Object(r.requestTryAndRepeatUntil)(s,{max:-1,slowThreshold:-15},(function(t){return"UP"===t.status}))}},911:function(t,e,n){"use strict";n.d(e,"a",(function(){return o})),n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return s}));var r=n(49),a=n(673);function o(t){return Object(r.getJSON)("/api/navigation/component",t).catch(a.a)}function i(){return Object(r.getJSON)("/api/navigation/marketplace").catch(a.a)}function s(){return Object(r.getJSON)("/api/navigation/settings").catch(a.a)}},915:function(t,e,n){var r=n(769),a=n(678),o=n(736),i=Math.max,s=Math.min;t.exports=function(t,e,n){var c=null==t?0:t.length;if(!c)return-1;var u=c-1;return void 0!==n&&(u=o(n),u=n<0?i(c+u,0):s(u,c-1)),r(t,a(e,3),u,!0)}},986:function(t,e,n){"use strict";n.d(e,"a",(function(){return s}));var r=n(181),a=n.n(r),o=n(907),i=n(763);function s(){var t=Object(i.default)(),e=a()(),n=window.location.pathname+window.location.search+window.location.hash;t.dispatch(Object(o.c)()),e.replace({pathname:"/sessions/new",query:{return_to:n}})}},987:function(t,e,n){"use strict";n.d(e,"b",(function(){return l})),n.d(e,"e",(function(){return p})),n.d(e,"c",(function(){return b})),n.d(e,"d",(function(){return g})),n.d(e,"f",(function(){return v})),n.d(e,"g",(function(){return y})),n.d(e,"h",(function(){return O})),n.d(e,"i",(function(){return _})),n.d(e,"a",(function(){return j}));var r=n(915),a=n.n(r),o=n(49),i=n(750),s=n(673),c=n(866),u=function(){return(u=Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++)for(var a in e=arguments[n])Object.prototype.hasOwnProperty.call(e,a)&&(t[a]=e[a]);return t}).apply(this,arguments)};function l(){return Object(o.getJSON)("/api/plugins/available").catch(s.a)}function p(){return Object(o.getJSON)("/api/plugins/pending").catch(s.a)}function f(t){return t?["COMPATIBLE","REQUIRES_SYSTEM_UPGRADE","DEPS_REQUIRE_SYSTEM_UPGRADE"].map((function(e){var n=a()(t,(function(t){return t.status===e}));return n>-1?t[n]:void 0})).filter(i.isDefined):[]}function m(t,e){if(!e)return t;var n=e.indexOf(t),r=n>0?e.slice(0,n):[];return u(u({},t),{previousUpdates:r})}function d(t){return void 0===t&&(t=c.a.External),Object(o.getJSON)("/api/plugins/installed",{f:"category",type:t})}function h(){return Object(o.getJSON)("/api/plugins/updates")}function b(t){return void 0===t&&(t=c.a.External),d(t).then((function(t){return t.plugins}),s.a)}function g(){return Promise.all([d(),h()]).then((function(t){var e=t[0],n=t[1];return e.plugins.map((function(t){var e=n.plugins.find((function(e){return e.key===t.key}));return e?u(u(u({},e),t),{updates:f(e.updates).map((function(t){return m(t,e.updates)}))}):t}))})).catch(s.a)}function v(){return Promise.all([h(),d()]).then((function(t){var e=t[0],n=t[1];return e.plugins.map((function(t){var e=f(t.updates).map((function(e){return m(e,t.updates)})),r=n.plugins.find((function(e){return e.key===t.key}));return u(u(r?u({},r):{},t),{updates:e})}))})).catch(s.a)}function y(t){return Object(o.post)("/api/plugins/install",t).catch(s.a)}function O(t){return Object(o.post)("/api/plugins/uninstall",t).catch(s.a)}function _(t){return Object(o.post)("/api/plugins/update",t).catch(s.a)}function j(){return Object(o.post)("/api/plugins/cancel_all").catch(s.a)}}}]);
//# sourceMappingURL=294.1655372229846.chunk.js.map