import{u as m,r as c,G as f,j as r,L as u}from"./index.js";import{E as x}from"./ErrorComponent.js";import{I as l}from"./IconComponent.js";import{u as p}from"./useDispatch.js";function E(){var s=m(function(e){return e.taxonomies}),n=s.taxonomiesLoading,o=s.taxonomiesErrorMessage,a=s.frameworks,t=p();return c.useEffect(function(){t(f())},[t]),n?r.jsx(u,{}):o?r.jsx(x,{message:o}):r.jsxs("main",{className:"frameworks",children:[r.jsx("h1",{className:"title",children:"frameworks"}),Array.isArray(a)&&a.map(function(e,i){return r.jsx(r.Fragment,{children:r.jsx("a",{href:"".concat(e.url),children:r.jsxs("div",{className:"skill",children:[r.jsx(l,{icon:e.icon},i),r.jsx("h3",{className:"title",children:e.title})]})})})})]})}export{E as default};
//# sourceMappingURL=Frameworks.js.map
