import{u as t,r as n,l as c,j as s}from"./index.js";import{I as o}from"./IconComponent.js";import{u as m}from"./useDispatch.js";function h(){var e=t(function(r){return r.taxonomies});e.skillsLoading,e.skillsError,e.skillsErrorMessage;var i=e.skills,l=m();return n.useEffect(function(){l(c())},[l]),s.jsxs("main",{className:"skills",children:[s.jsx("h1",{className:"title",children:"skills"}),Array.isArray(i)&&i.map(function(r,a){return s.jsx(s.Fragment,{children:s.jsx("a",{href:"".concat(r.url),children:s.jsxs("div",{className:"skill",children:[s.jsx(o,{icon:r.icon},a),s.jsx("h3",{className:"title",children:r.title})]})})})}),s.jsx("div",{children:"Skills"})]})}export{h as default};
//# sourceMappingURL=Skills.js.map