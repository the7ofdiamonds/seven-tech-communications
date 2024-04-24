import{u as S,r as e,a as v,_ as l,j as t,L}from"./index.js";import{C as T}from"./ContentComponent.js";import{M as y,S as N}from"./StatusBarComponent.js";import{u as w}from"./useDispatch.js";function R(){var f=w(),s=S(function(i){return i.content}),C=s.contentLoading,m=s.contentStatusCode,a=s.contentErrorMessage,x=s.title,j=s.content,n=S(function(i){return i.contact});n.contactLoading;var d=n.contactStatusCode,o=n.contactErrorMessage,c=n.contactSuccessMessage;e.useEffect(function(){f(v("/contact"))},[f]),e.useEffect(function(){m&&a&&(r("error"),u(a))},[m,a]),e.useEffect(function(){d&&o&&(r("error"),u(o))},[d,o]),e.useEffect(function(){c&&(r("success"),u(c),setTimeout(function(){window.location.href="/"},3e3))},[c]);var E=e.useState(""),g=l(E,2),M=g[0],r=g[1],h=e.useState(""),p=l(h,2),_=p[0],u=p[1];return C?t.jsx(L,{}):t.jsx(t.Fragment,{children:t.jsxs("main",{className:"contact",children:[t.jsx("h2",{className:"title",children:x}),t.jsx(T,{content:j}),t.jsx("div",{className:"contact-card card",children:t.jsx(y,{page:"/contact"})}),t.jsx(N,{messageType:M,message:_})]})})}export{R as default};
//# sourceMappingURL=Contact.js.map
