import{u as f,r,a as m,j as t,L as l}from"./index.js";import{C as p}from"./ContentComponent.js";import{u as d}from"./useDispatch.js";function C(){var s=d(),e=f(function(u){return u.content}),a=e.contentLoading,o=e.contentStatusCode,n=e.contentErrorMessage,c=e.title,i=e.content;return r.useEffect(function(){s(m("/faq"))},[s]),r.useEffect(function(){o&&n&&(setMessageType("error"),setMessage(n))},[o,n]),a?t.jsx(l,{}):t.jsx(t.Fragment,{children:t.jsxs("main",{className:"faq",children:[t.jsx("h2",{className:"title",children:c}),t.jsx(p,{content:i})]})})}export{C as default};
//# sourceMappingURL=FAQ.js.map
