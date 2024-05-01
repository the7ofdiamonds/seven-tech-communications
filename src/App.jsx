import { lazy, Suspense } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import { Provider } from 'react-redux';

import store from './model/store.js';

import LoadingComponent from './views/components/LoadingComponent';

const About = lazy(() => import('./views/About.jsx'));
const FAQ = lazy(() => import('./views/FAQ.jsx'));
const Contact = lazy(() => import('./views/Contact.jsx'));
const Support = lazy(() => import('./views/Support.jsx'));

const Employees = lazy(() => import('./views/Employees.jsx'));
const Employee = lazy(() => import('./views/Employee.jsx'));

const Founders = lazy(() => import('./views/Founders.jsx'));
const Founder = lazy(() => import('./views/Founder.jsx'));
const Team = lazy(() => import('./views/Team.jsx'));
const TeamMember = lazy(() => import('./views/Team-Member.jsx'));

const Skills = lazy(() => import('./views/Skills.jsx'));
const Skill = lazy(() => import('./views/Skill.jsx'));

function App() {
  return (
    <>
      <Provider store={store}>
        <Router>
          <Suspense fallback={<LoadingComponent />}>
            <Routes>
              <Route path="/" element={<About />} />
              <Route path="/about" element={<About />} />
              <Route path="contact" element={<Contact />} />
              <Route path="faq" element={<FAQ />} />
              <Route path="support" element={<Support />} />
              <Route path="employees" element={<Employees />} />
              <Route path="/founders" element={<Founders />} />
              <Route path="/founders/:founder" element={<Founder />} />
              <Route path="/skills" element={<Skills />} />
              <Route path="/skills/:skill" element={<Skill />} />
              <Route path="/team" element={<Team />} />
              <Route path="/team/:teammember" element={<TeamMember />} />
            </Routes>
          </Suspense>
        </Router>
      </Provider>
    </>
  );
}

export default App;
