import{h as j,r as o,a as C,i as h,u as a,j as r,L as _}from"./index.js";import{M as E,a as R}from"./MemberIntroductionComponent.js";import{C as S}from"./ContentComponent.js";import{u as k}from"./useDispatch.js";function N(){var s=new URL(window.location.href),u=s.pathname,i=j(),f=i.founder,n=k();o.useEffect(function(){n(C(u))},[n]),o.useEffect(function(){n(h(f))},[n]);var e=a(function(t){return t.founder}),m=e.founderLoading;e.founderError;var l=e.title,c=e.avatarURL,d=e.fullName,g=e.greeting,p=e.skills,v=e.founder_resume,x=a(function(t){return t.content}),L=x.content;return m?r.jsx(_,{}):r.jsxs(r.Fragment,{children:[r.jsx(E,{title:l,avatarURL:c,fullName:d,greeting:g,founder_resume:v}),r.jsx(S,{content:L}),r.jsx(R,{skills:p})]})}export{N as default};
//# sourceMappingURL=Founder.js.map