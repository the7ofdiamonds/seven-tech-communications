import{r as o,g as x,a as g,b as j,u as a,j as t,L as h}from"./index.js";import{C as S}from"./ContentComponent.js";import{F as C}from"./FoundersComponent.js";import{u as E}from"./useDispatch.js";import"./GroupMembers.js";function N(){var e=E();o.useEffect(function(){i&&r&&(setMessageType("error"),setMessage(r))},[i,r]),o.useEffect(function(){e(x())},[e]),o.useEffect(function(){e(g("/about"))},[e]),o.useEffect(function(){e(j())},[e]);var c=a(function(s){return s.about}),u=c.missionStatement,n=a(function(s){return s.content}),f=n.contentLoading,i=n.contentStatusCode,r=n.contentErrorMessage,m=n.title,d=n.content,l=a(function(s){return s.founder}),p=l.founders;return f?t.jsx(h,{}):t.jsx(t.Fragment,{children:t.jsxs("main",{children:[t.jsx("h1",{className:"title",children:m}),t.jsx("div",{className:"mission-statement-card card",children:t.jsx("h3",{className:"mission-statement",children:t.jsx("q",{children:u})})}),t.jsx(S,{content:d}),t.jsx(C,{founders:p})]})})}export{N as default};
//# sourceMappingURL=About.js.map
