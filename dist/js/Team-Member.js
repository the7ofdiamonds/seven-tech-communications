import{h as p,r as g,q as d,u as x,j as a,L as b}from"./index.js";import{b as j,M as v,a as L}from"./MemberComponent.js";import{u as M}from"./useDispatch.js";import"./IconComponent.js";function E(){var s=p(),t=s.teammember,r=M();g.useEffect(function(){r(d(t))},[r,t]);var e=x(function(f){return f.team}),m=e.teamLoading;e.teamError;var n=e.title,o=e.avatarURL,i=e.fullName,u=e.greeting,l=e.skills,c=e.teamResume;return m?a.jsx(b,{}):a.jsxs("section",{className:"team-member",children:[a.jsx(j,{resume:c}),a.jsx("main",{class:"founder",children:a.jsx(v,{title:n,avatarURL:o,fullName:i,greeting:u})}),a.jsx(L,{skills:l})]})}export{E as default};
//# sourceMappingURL=Team-Member.js.map
