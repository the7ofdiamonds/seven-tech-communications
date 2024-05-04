import{h as k,u as t,r as n,y as w,z as F,A as b,B as S,C as _,D as L,j as o}from"./index.js";import{H as T}from"./HeaderIconComponent.js";import{G as i}from"./GroupMembers.js";import{u as W}from"./useDispatch.js";import"./IconComponent.js";function P(){var x=k(),s=x.framework,a=t(function(r){return r.taxonomies});a.taxonomiesLoading,a.taxonomiesErrorMessage,a.id;var p=a.title,d=a.icon,l=a.description,v=a.url,m=t(function(r){return r.founder});m.founderLoading,m.founderErrorMessage;var E=m.founders,u=t(function(r){return r.executive});u.executiveLoading,u.executiveErrorMessage;var M=u.executives,c=t(function(r){return r.managingMember});c.managingMemberLoading,c.managingMemberErrorMessage;var y=c.managingMembers,f=t(function(r){return r.freelancer});f.freelancerLoading,f.freelancerErrorMessage;var h=f.freelancers,g=t(function(r){return r.employee});g.employeeLoading,g.employeeErrorMessage;var j=g.employees,e=W();return n.useEffect(function(){e(w(s))},[e]),n.useEffect(function(){e(F({taxonomy:"Frameworks",term:s}))},[e]),n.useEffect(function(){e(b({taxonomy:"Frameworks",term:s}))},[e]),n.useEffect(function(){e(S({taxonomy:"Frameworks",term:s}))},[e]),n.useEffect(function(){e(_({taxonomy:"Frameworks",term:s}))},[e]),n.useEffect(function(){e(L({taxonomy:"Frameworks",term:s}))},[e]),o.jsxs("main",{className:"framework",children:[o.jsx(T,{icon:d,title:p,url:v}),l&&o.jsx("div",{className:"card",children:o.jsx("p",{children:l})}),o.jsx(i,{group:E}),o.jsx(i,{group:M}),o.jsx(i,{group:y}),o.jsx(i,{group:h}),o.jsx(i,{group:j})]})}export{P as default};
//# sourceMappingURL=Framework.js.map
