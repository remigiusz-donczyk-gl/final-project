(window.webpackJsonp=window.webpackJsonp||[]).push([[13],{1786:function(t,e,n){"use strict";n.r(e),n.d(e,"PageTracker",(function(){return p}));var a=n(2),c=n(335),s=n(325),o=n(367),r=n(1787),i=n(531),u=n(17),d=n(6),l=n(327);class p extends a.Component{constructor(){super(...arguments),this.state={},this.trackPage=()=>{const{location:t,trackingIdGTM:e}=this.props,{lastLocation:n}=this.state,{dataLayer:a}=window,c=t.pathname!==n,s=Object(u.b)();s&&c?(this.setState({lastLocation:t.pathname}),setTimeout(()=>s(t.pathname),500)):a&&a.push&&e&&"/"!==t.pathname&&(this.setState({lastLocation:t.pathname}),setTimeout(()=>a.push({event:"render-end"}),500))}}componentDidMount(){const{trackingIdGTM:t,webAnalytics:e}=this.props;e&&!Object(u.b)()&&Object(i.b)(e,"head"),t&&Object(r.gtm)(t)}render(){const{trackingIdGTM:t,webAnalytics:e}=this.props;return a.createElement(c.a,{defaultTitle:Object(d.getInstance)(),defer:!1,onChangeClientState:t||e?this.trackPage:void 0},this.props.children)}}e.default=Object(o.a)(Object(s.b)(t=>{const e=Object(l.getGlobalSettingValue)(t,"sonar.analytics.gtm.trackingId");return{trackingIdGTM:e&&e.value,webAnalytics:Object(l.getAppState)(t).webAnalyticsJsPath}})(p))},1787:function(t,e,n){"use strict";t.exports={gtm:t=>function(t,e,n,a,c){t[a]=t[a]||[],t[a].push({"gtm.start":(new Date).getTime(),event:"gtm.js"});const s=e.getElementsByTagName(n)[0],o=e.createElement(n);o.async=!0,o.src="https://www.googletagmanager.com/gtm.js?id="+c,s.parentNode.insertBefore(o,s)}(window,document,"script","dataLayer",t)}},531:function(t,e,n){"use strict";n.d(e,"b",(function(){return o})),n.d(e,"a",(function(){return r}));var a=n(339),c=n(17);let s=!1;function o(t,e="body"){return new Promise(n=>{const c=document.createElement("script");c.src="".concat(Object(a.getBaseUrl)()).concat(t),c.onload=n,document.getElementsByTagName(e)[0].appendChild(c)})}async function r(t){const e=Object(c.a)(t);if(e)return Promise.resolve(e);if(!s){s=!0,(0,(await Promise.all([n.e(0),n.e(1),n.e(2),n.e(273),n.e(317)]).then(n.bind(null,688))).default)()}await o("/static/".concat(t,".js"));const a=Object(c.a)(t);return a||Promise.reject()}}}]);
//# sourceMappingURL=13.m.78f03f86.chunk.js.map