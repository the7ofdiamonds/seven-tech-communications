import{j as a,l as r}from"./index.js";function t(i){var l=i.group;return a.jsx(a.Fragment,{children:(l==null?void 0:l.length)>0&&l.map(function(s){return a.jsx("div",{className:"group",children:s&&r(s)==="object"&&a.jsxs("div",{className:"author-card card",children:[a.jsx("div",{className:"author-pic",children:a.jsx("a",{href:s.user_url?s.user_url:"",children:a.jsx("img",{src:s.avatar_url,alt:""})})}),a.jsx("div",{className:"author-name",children:a.jsxs("h4",{className:"title",children:[s.first_name," ",s.last_name]})}),Array.isArray(s.roles)&&s.roles.map(function(c){return a.jsx("div",{className:"role",children:a.jsx("h5",{children:c})})}),a.jsx("div",{className:"author-contact",children:a.jsx("a",{href:"mailto:".concat(s.email),children:a.jsx("i",{className:"fa fa-envelope fa-fw"})})})]})},s.id)})})}export{t as G};
//# sourceMappingURL=GroupMembers.js.map
