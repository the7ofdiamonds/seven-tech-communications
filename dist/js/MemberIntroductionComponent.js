import{r as c,j as e}from"./index.js";function g(t){var l=t.skills,s=c.useRef(null);return c.useEffect(function(){var n=s.current;if(n){for(var o=n.children.length,r=0;r<o;r++)n.appendChild(n.children[r].cloneNode(!0));document.documentElement.style.setProperty("--total-skills",o)}},[l]),e.jsx(e.Fragment,{children:Array.isArray(l)&&l.length>0?e.jsx("div",{className:"author-skills",children:e.jsx("div",{className:"author-skills-slide",ref:s,children:l.map(function(n,o){return e.jsx("i",{className:"fa-brands fa-".concat(n.slug.toLowerCase())},o)})})}):null})}function x(t){var l=t.resume,s=t.portfolioElement,n=function(i){var a=document.getElementById(i);if(a){var u=a.getBoundingClientRect().top+window.scrollY,d=137.5,m=parseFloat(getComputedStyle(document.documentElement).fontSize),h=d/16,f=h*m,v=u-f;window.scrollTo({top:v,behavior:"smooth"})}},o=function(){window.open("resume","_blank")};return e.jsx(e.Fragment,{children:l!=null||s!=null?e.jsxs("nav",{class:"author-nav",children:[s?e.jsxs(e.Fragment,{children:[e.jsx("button",{onClick:function(){return n("author_intro")},id:"founder_button",children:e.jsx("h3",{className:"title",children:"intro"})}),e.jsx("button",{onClick:function(){return n("seven_tech_portfolio")},id:"portfolio_button",children:e.jsx("h3",{className:"title",children:"PORTFOLIO"})})]}):"",l?e.jsx("button",{onClick:o,children:e.jsx("h3",{className:"title",children:"RÉSUMÉ"})}):""]}):""})}function p(t){var l=t.title,s=t.avatarURL,n=t.fullName,o=t.greeting,r=t.founder_resume,i=document.getElementById("seven_tech_portfolio");return e.jsxs("main",{class:"author-intro",id:"author_intro",children:[(r||i)&&e.jsx(x,{resume:r,portfolioElement:i}),e.jsx("h2",{class:"title",children:n}),e.jsxs("div",{className:"author-info",children:[e.jsxs("div",{class:"author",children:[e.jsx("div",{class:"author-card card",children:e.jsx("div",{class:"author-pic",children:e.jsx("img",{src:s,alt:""})})}),e.jsx("h4",{class:"title",children:l})]}),o&&e.jsx("div",{class:"author-card card",children:e.jsx("p",{class:"author-bio",children:o})})]})]})}export{p as M,g as a,x as b};
//# sourceMappingURL=MemberIntroductionComponent.js.map
