import{j as e,u as i,r as t,w as o,L as M}from"./index.js";import{E as u}from"./ErrorComponent.js";import{G as b}from"./GroupMembers.js";import{u as c}from"./useDispatch.js";function p(r){var a=r.ManagingMembers;return e.jsx(e.Fragment,{children:Array.isArray(a)&&e.jsxs(e.Fragment,{children:[e.jsx("h1",{className:"title",children:"Managing Members"}),e.jsx(b,{group:a})]})})}function d(){var r=i(function(g){return g.managingMember}),a=r.managingMemberLoading,n=r.managingMemberErrorMessage,m=r.managingMembers,s=c();return t.useEffect(function(){s(o())},[s]),a?e.jsx(M,{}):n?e.jsx(u,{message:n}):e.jsx("main",{className:"managing-members",children:e.jsx(p,{ManagingMembers:m})})}export{d as default};
//# sourceMappingURL=Managing-Members.js.map
