import { lazy, Suspense } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import { Provider } from 'react-redux';

import store from './model/store.js';

import LoadingComponent from './loading/LoadingComponent';

const About = lazy(() => import('./views/About.jsx'));
const FAQ = lazy(() => import('./views/FAQ.jsx'));
const Contact = lazy(() => import('./views/Contact.jsx'));
const Support = lazy(() => import('./views/Support.jsx'));

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
            </Routes>
          </Suspense>
        </Router>
      </Provider>
    </>
  );
}

export default App;
