import{u as n,r as p,f as l,j as e,L as i}from"./index.js";import{E as u}from"./ErrorComponent.js";import{u as c}from"./useDispatch.js";function d(){var r=n(function(m){return m.employee}),t=r.employeeLoading,s=r.employeeErrorMessage;r.employeeStatusCode;var o=r.employees,a=c();return p.useEffect(function(){a(l())},[a]),t?e.jsx(i,{}):s?e.jsx(u,{message:s}):e.jsx(e.Fragment,{children:e.jsx("main",{className:"employees",children:Array.isArray(o)&&e.jsxs(e.Fragment,{children:[e.jsx("h1",{className:"title",children:"Employees"}),e.jsx(GroupMembers,{group:o})]})})})}export{d as default};
//# sourceMappingURL=Employees.js.map