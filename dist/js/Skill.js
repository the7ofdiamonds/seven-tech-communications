import{j as r,h as S,u as o,r as a,B as y,C as k,D as b,E as _,F as L,G as T}from"./index.js";import{I as W}from"./IconComponent.js";import{G as i}from"./GroupMembers.js";import{u as N}from"./useDispatch.js";function C(c){var n=c.title,t=c.icon;return r.jsxs("div",{className:"header-icon",children:[r.jsx(W,{icon:t}),r.jsx("h1",{className:"title",children:n})]})}function P(){var c=S(),n=c.skill,t=o(function(s){return s.taxonomies});t.taxonomiesLoading,t.taxonomiesErrorMessage,t.id;var d=t.title,p=t.icon,x=t.description,u=o(function(s){return s.founder});u.founderLoading,u.founderErrorMessage;var v=u.founders,l=o(function(s){return s.executive});l.executiveLoading,l.executiveErrorMessage;var E=l.executives,m=o(function(s){return s.managingMember});m.managingMemberLoading,m.managingMemberErrorMessage;var h=m.managingMembers,f=o(function(s){return s.freelancer});f.freelancerLoading,f.freelancerErrorMessage;var j=f.freelancers,g=o(function(s){return s.employee});g.employeeLoading,g.employeeErrorMessage;var M=g.employees,e=N();return a.useEffect(function(){e(y(n))},[e]),a.useEffect(function(){e(k({taxonomy:"Skills",term:n}))},[e]),a.useEffect(function(){e(b({taxonomy:"Skills",term:n}))},[e]),a.useEffect(function(){e(_({taxonomy:"Skills",term:n}))},[e]),a.useEffect(function(){e(L({taxonomy:"Skills",term:n}))},[e]),a.useEffect(function(){e(T({taxonomy:"Skills",term:n}))},[e]),r.jsxs("main",{className:"skill",children:[r.jsx(C,{icon:p,title:d}),x&&r.jsx("div",{className:"card",children:r.jsx("p",{children:x})}),r.jsx(i,{group:v}),r.jsx(i,{group:E}),r.jsx(i,{group:h}),r.jsx(i,{group:j}),r.jsx(i,{group:M})]})}export{P as default};
//# sourceMappingURL=Skill.js.map
