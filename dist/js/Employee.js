import{i as h,r as v,k,u as C,j as o,L,l as t}from"./index.js";import{M as b,a as E}from"./MemberComponent.js";import{C as w}from"./ContentComponent.js";import{u as M}from"./useDispatch.js";import"./IconComponent.js";function S(){var a=h(),s=a.employee,r=M();v.useEffect(function(){r(k(s))},[r]);var e=C(function(x){return x.employee}),n=e.employeeLoading;e.employeeErrorMessage;var m=e.title,l=e.avatarURL,i=e.fullName,p=e.bio,u=e.projectTypes,c=e.skills,f=e.frameworks,d=e.technologies,g=e.resume,y=e.content;if(n)return o.jsx(L,{});var j=[].concat(t(u||[]),t(c||[]),t(f||[]),t(d||[]));return o.jsx(o.Fragment,{children:o.jsxs("main",{class:"author-intro",id:"author_intro",children:[o.jsx(b,{title:m,avatarURL:l,fullName:i,bio:p,resume:g}),o.jsx(w,{content:y}),o.jsx(E,{knowledge:j})]})})}export{S as default};
//# sourceMappingURL=Employee.js.map
