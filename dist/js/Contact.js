import{u as F,r as o,a as O,_ as j,j as e,b as y,c as A,d as P,e as N}from"./index.js";import{u as U,C as $}from"./ContentComponent.js";function q(){var g=U(),w=F(function(c){return c.content}),T=w.content;o.useEffect(function(){g(O("contact"))},[g]);var D=o.useState(""),f=j(D,2),E=f[0],m=f[1],k=o.useState(""),x=j(k,2),v=x[0],u=x[1],I=o.useState({first_name:"",last_name:"",email:"",subject:"",message:""}),b=j(I,2),s=b[0],M=b[1],d=s.first_name,S=s.last_name,p=s.email,_=s.subject,C=s.msg,n=function(i){var t=i.target,l=t.name,r=t.value;M(y(y({},s),{},A({},l,r)))},R=function(){var c=P(N().mark(function i(){var t,l,r,h;return N().wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return a.prev=0,a.next=3,fetch("/wp-json/orb/v1/email/contact",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({first_name:d,last_name:S,email:p,subject:_,message:C})});case 3:if(t=a.sent,t.ok){a.next=12;break}return a.next=7,t.json();case 7:throw l=a.sent,r=l.message,u(r),m("error"),new Error(r);case 12:return a.next=14,t.json();case 14:return h=a.sent,u(h.message),m("success"),setTimeout(function(){window.location.href="/contact/success?first_name=".concat(encodeURIComponent(d),"&email=").concat(encodeURIComponent(p))},3e3),a.abrupt("return",h);case 21:throw a.prev=21,a.t0=a.catch(0),u(a.t0.message),m("error"),a.t0.message;case 26:case"end":return a.stop()}},i,null,[[0,21]])}));return function(){return c.apply(this,arguments)}}();return e.jsx(e.Fragment,{children:e.jsxs("main",{className:"contact",children:[e.jsx("h2",{className:"title",children:"CONTACT"}),e.jsx($,{content:T}),e.jsx("div",{className:"contact-card card",children:e.jsx("form",{children:e.jsx("table",{children:e.jsxs("tbody",{children:[e.jsxs("tr",{children:[e.jsx("td",{children:e.jsx("input",{type:"text",name:"first_name",className:"input",id:"first_name",placeholder:"First Name",onChange:n,value:d})}),e.jsx("td",{children:e.jsx("input",{type:"text",name:"last_name",className:"input",id:"last_name",placeholder:"Last Name",onChange:n,value:S})})]}),e.jsx("tr",{children:e.jsx("td",{colSpan:2,children:e.jsx("input",{name:"email",type:"email",id:"contact_email",className:"input",placeholder:"Email",onChange:n,value:p})})}),e.jsx("tr",{children:e.jsx("td",{colSpan:2,children:e.jsx("input",{name:"subject",type:"text",id:"contact_subject",className:"input",placeholder:"Subject",onChange:n,value:_})})}),e.jsx("tr",{children:e.jsx("td",{colSpan:2,children:e.jsx("textarea",{name:"msg",type:"text",id:"contact_message",placeholder:"Message",onChange:n,value:C})})}),e.jsx("tr",{children:e.jsxs("td",{colSpan:2,children:[e.jsx("input",{type:"hidden",name:"action",value:"thfw_email_contact"}),e.jsx("button",{className:"sendmsg",id:"contact_submit",name:"submit",type:"button",value:"submit",onClick:R,children:e.jsx("h3",{children:"SEND"})})]})})]})})})}),v&&e.jsx("div",{className:"status-bar card ".concat(E),children:e.jsx("span",{children:v})})]})})}export{q as default};
//# sourceMappingURL=Contact.js.map