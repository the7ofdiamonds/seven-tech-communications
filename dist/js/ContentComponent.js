import{R as r,f as c,h as x,j as o}from"./index.js";function a(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:r,t=e===r?c:x(e);return function(){var n=t(),s=n.store;return s}}var i=a();function d(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:r,t=e===r?i:a(e);return function(){var n=t();return n.dispatch}}var f=d();function g(e){var t=e.content;return o.jsx(o.Fragment,{children:t?t.map(function(u,n){return o.jsx("div",{className:"card",dangerouslySetInnerHTML:{__html:u}},n)}):null})}export{g as C,f as u};
//# sourceMappingURL=ContentComponent.js.map