import{h as k,r as s,a as E,i as b,u as l,j as o,L as R,k as r}from"./index.js";import{M as _,a as M}from"./MemberComponent.js";import{C as S}from"./ContentComponent.js";import{u as U}from"./useDispatch.js";import"./IconComponent.js";function F(){var m=new URL(window.location.href),i=m.pathname,u=k(),n=u.employee,t=U();console.log(n),s.useEffect(function(){t(E(i))},[t]),s.useEffect(function(){t(b(n))},[t]);var e=l(function(a){return a.employee}),c=e.employeeLoading;e.employeeErrorMessage;var p=e.title,f=e.avatarURL,g=e.fullName,d=e.bio,h=e.projectTypes,v=e.skills,y=e.frameworks,j=e.technologies,x=e.resume,w=l(function(a){return a.content}),C=w.content;if(c)return o.jsx(R,{});var L=[].concat(r(h||[]),r(v||[]),r(y||[]),r(j||[]));return o.jsx(o.Fragment,{children:o.jsxs("main",{class:"author-intro",id:"author_intro",children:[o.jsx(_,{title:p,avatarURL:f,fullName:g,bio:d,resume:x}),o.jsx(S,{content:C}),o.jsx(M,{knowledge:L})]})})}export{F as default};
//# sourceMappingURL=Employee.js.map
