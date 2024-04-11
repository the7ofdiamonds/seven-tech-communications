import { lazy, Suspense } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import { Provider } from 'react-redux';

import store from './model/store.js';

import LoadingComponent from './loading/LoadingComponent';

const About = lazy(() => import('./views/About.jsx'));
const FAQ = lazy(() => import('./views/FAQ.jsx'));
const Support = lazy(() => import('./views/Support.jsx'));
const SupportSuccess = lazy(() => import('./views/SupportSuccess.jsx'));
const Contact = lazy(() => import('./views/Contact.jsx'));
const ContactSuccess = lazy(() => import('./views/ContactSuccess.jsx'));

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
              <Route path="contact/success" element={<ContactSuccess />} />
              <Route path="faq" element={<FAQ />} />
              <Route path="support" element={<Support />} />
              <Route path="support/success" element={<SupportSuccess />} />
            </Routes>
          </Suspense>
        </Router>
      </Provider>
    </>
  );
}

export default App;
