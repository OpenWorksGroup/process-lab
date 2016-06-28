import React from 'react';
import ReactDOM from 'react-dom';
import TemplateForm from './components/template.jsx';
import CompetencyFrameworkForm from './components/competency_framework_form.jsx';
/** mockups **/
import GradeTags from './components/mockups/grade_tags.jsx';
import SubjectTags from './components/mockups/subject_tags.jsx';

$(() => {
  var templateForm  = document.querySelector('#template');

  if (templateForm) {
    ReactDOM.render(<TemplateForm />,templateForm);
  }

  var competencyFrameworkForm  = document.querySelector('#competency-framework-editor');
  var frameworkId = $('#competency-framework-editor').attr('data-frameworkId');


  if (competencyFrameworkForm) {
        if (frameworkId) {
            ReactDOM.render(<CompetencyFrameworkForm frameworkId={frameworkId}/>,competencyFrameworkForm);
        }
        else {
            ReactDOM.render(<CompetencyFrameworkForm />,competencyFrameworkForm);
        }
  }


  /** mockups  **/
  var gradeTags  = document.querySelector('#grade-tags');

  if (gradeTags) {
    ReactDOM.render(<GradeTags />,gradeTags);
  }

  var subjectTags  = document.querySelector('#subject-tags');

  if (subjectTags) {
    ReactDOM.render(<SubjectTags />,subjectTags);
  }

});