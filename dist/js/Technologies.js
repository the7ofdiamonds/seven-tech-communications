import{u as i,r as m,M as c,j as e,L as l}from"./index.js";import{E as u}from"./ErrorComponent.js";import{T as x}from"./TaxTableComponent.js";import{u as g}from"./useDispatch.js";import"./IconComponent.js";function E(){var o=i(function(a){return a.taxonomies}),r=o.taxonomiesLoading,s=o.taxonomiesErrorMessage,n=o.technologies,t=g();return m.useEffect(function(){t(c())},[t]),r?e.jsx(l,{}):s?e.jsx(u,{message:s}):e.jsxs("main",{className:"technologies",children:[e.jsx("h1",{className:"title",children:"technologies"}),e.jsx(x,{terms:n})]})}export{E as default};
//# sourceMappingURL=Technologies.js.map