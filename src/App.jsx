import { lazy, Suspense } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import { Provider } from 'react-redux';

import store from './model/store.js';

import LoadingComponent from './views/components/LoadingComponent';

const About = lazy(() => import('./views/About.jsx'));
const FAQ = lazy(() => import('./views/FAQ.jsx'));
const Contact = lazy(() => import('./views/Contact.jsx'));
const Support = lazy(() => import('./views/Support.jsx'));

const Founders = lazy(() => import('./views/Founders.jsx'));
const Founder = lazy(() => import('./views/Founder.jsx'));
const Team = lazy(() => import('./views/Team.jsx'));
const TeamMember = lazy(() => import('./views/TeamMember.jsx'));

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
              <Route path="/founders" element={<Founders />} />
              <Route path="/founders/:founder" element={<Founder />} />
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
