import{i as _,r as n,G as b,z as T,A as W,B as C,C as L,D as G,u as i,j as s,L as D}from"./index.js";import{E as F}from"./ErrorComponent.js";import{H}from"./HeaderIconComponent.js";import{G as a}from"./GroupMembers.js";import{u as N}from"./useDispatch.js";import"./IconComponent.js";function q(){var c=_(),o=c.skill,e=N();n.useEffect(function(){e(b(o))},[e]),n.useEffect(function(){e(T({taxonomy:"Skills",term:o}))},[e]),n.useEffect(function(){e(W({taxonomy:"Skills",term:o}))},[e]),n.useEffect(function(){e(C({taxonomy:"Skills",term:o}))},[e]),n.useEffect(function(){e(L({taxonomy:"Skills",term:o}))},[e]),n.useEffect(function(){e(G({taxonomy:"Skills",term:o}))},[e]);var t=i(function(r){return r.taxonomies}),l=t.taxonomiesLoading,u=t.taxonomiesErrorMessage;t.id;var f=t.title,x=t.icon,m=t.description,p=t.url,g=i(function(r){return r.founder}),d=g.founders,v=i(function(r){return r.executive}),E=v.executives,S=i(function(r){return r.managingMember}),j=S.managingMembers,h=i(function(r){return r.freelancer}),k=h.freelancers,y=i(function(r){return r.employee}),M=y.employees;return l?s.jsx(D,{}):u?s.jsx(F,{message:u}):s.jsxs("main",{className:"skill",children:[s.jsx(H,{icon:x,title:f,url:p}),m&&s.jsx("div",{className:"card",children:s.jsx("p",{children:m})}),s.jsx(a,{group:d}),s.jsx(a,{group:E}),s.jsx(a,{group:j}),s.jsx(a,{group:k}),s.jsx(a,{group:M})]})}export{q as default};
//# sourceMappingURL=Skill.js.map
