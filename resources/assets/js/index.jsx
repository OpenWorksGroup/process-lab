import React from 'react';
import ReactDOM from 'react-dom';
import TemplateForm from './components/template.jsx';

$(() => {
  var templateForm  = document.querySelector('#template');

  if (templateForm) {
    ReactDOM.render(<TemplateForm />,templateForm);
  }
});