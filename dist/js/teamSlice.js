import{i as p,e as f,f as i,k as h}from"./index.js";var c={teamLoading:!1,teamError:"",team:"",title:"",author_url:"",avatar_url:"",fullName:"",greeting:"",skills:"",teamResume:""},t=p("team/getTeam",f(i().mark(function l(){var n,e,a,u;return i().wrap(function(s){for(;;)switch(s.prev=s.next){case 0:return s.prev=0,s.next=3,fetch("/wp-json/seven-tech/v1/users/team",{method:"GET",headers:{"Content-Type":"application/json"}});case 3:if(n=s.sent,n.ok){s.next=10;break}return s.next=7,n.json();case 7:throw e=s.sent,a=e.message,new Error(a);case 10:return s.next=12,n.json();case 12:return u=s.sent,s.abrupt("return",u);case 16:throw s.prev=16,s.t0=s.catch(0),s.t0;case 19:case"end":return s.stop()}},l,null,[[0,16]])}))),o=p("team/getTeamMember",function(){var l=f(i().mark(function n(e){var a,u,m,s;return i().wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.prev=0,r.next=3,fetch("/wp-json/seven-tech/v1/users/team/".concat(e),{method:"GET",headers:{"Content-Type":"application/json"}});case 3:if(a=r.sent,a.ok){r.next=10;break}return r.next=7,a.json();case 7:throw u=r.sent,m=u.message,new Error(m);case 10:return r.next=12,a.json();case 12:return s=r.sent,r.abrupt("return",s);case 16:throw r.prev=16,r.t0=r.catch(0),r.t0;case 19:case"end":return r.stop()}},n,null,[[0,16]])}));return function(n){return l.apply(this,arguments)}}()),d=p("team/getTeamMemberResume",function(){var l=f(i().mark(function n(e){var a,u,m,s;return i().wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.prev=0,r.next=3,fetch("/wp-json/seven-tech/v1/users/team/".concat(e,"/resume"),{method:"GET",headers:{"Content-Type":"application/json"}});case 3:if(a=r.sent,a.ok){r.next=10;break}return r.next=7,a.json();case 7:throw u=r.sent,m=u.message,new Error(m);case 10:return r.next=12,a.json();case 12:return s=r.sent,r.abrupt("return",s);case 16:throw r.prev=16,r.t0=r.catch(0),r.t0;case 19:case"end":return r.stop()}},n,null,[[0,16]])}));return function(n){return l.apply(this,arguments)}}());h({name:"team",initialState:c,extraReducers:function(n){n.addCase(t.pending,function(e){e.teamLoading=!0,e.teamError=""}).addCase(t.fulfilled,function(e,a){e.teamLoading=!1,e.teamError=null,e.team=a.payload}).addCase(t.rejected,function(e,a){e.teamLoading=!1,e.teamError=a.error.message}).addCase(o.pending,function(e){e.teamLoading=!0,e.teamError=""}).addCase(o.fulfilled,function(e,a){e.teamLoading=!1,e.teamError=null,e.title=a.payload.title,e.authorURL=a.payload.author_url,e.avatarURL=a.payload.avatar_url,e.fullName=a.payload.fullName,e.greeting=a.payload.greeting,e.skills=a.payload.skills,e.teamResume=a.payload.teamResume}).addCase(o.rejected,function(e,a){e.teamLoading=!1,e.teamError=a.error.message}).addCase(d.pending,function(e){e.teamLoading=!0,e.teamError=""}).addCase(d.fulfilled,function(e,a){e.teamLoading=!1,e.teamError=null,e.teamResume=a.payload}).addCase(d.rejected,function(e,a){e.teamLoading=!1,e.teamError=a.error.message})}});export{o as a,t as g};
//# sourceMappingURL=teamSlice.js.map
