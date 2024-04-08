import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App.jsx';

const sevenTechCommunications = document.getElementById('seven_tech_communications');

if (sevenTechCommunications) {
  ReactDOM.createRoot(sevenTechCommunications).render(<App />);
}

