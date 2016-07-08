import React from 'react';
import ReactDOM from 'react-dom';
import TemplateForm from './components/template.jsx';
import CompetencyFrameworkForm from './components/competency_framework_form.jsx';
/** mockups **/
import GradeTags from './components/mockups/grade_tags.jsx';
import SubjectTags from './components/mockups/subject_tags.jsx';

$(() => {
  var templateForm  = document.querySelector('#template');
  var templateInfo = $('#template').attr('data-templateInfo');
  var courseInfo = $('#template').attr('data-courseInfo');
  var tags = $('#template').attr('data-tags');
  var sections = $('#template').attr('data-sections');
  var sectionsFields = $('#template').attr('data-sectionsFields');
  var rubric = $('#template').attr('data-rubric');
  var rubricCompetencies = $('#template').attr('data-rubricCompetencies');

  if (templateForm) {
    if (templateInfo) {
      ReactDOM.render(<TemplateForm 
        rubric={rubric}
        rubricCompetencies={rubricCompetencies}
        sections={sections}
        sectionsFields={sectionsFields}
        tags={tags} 
        courseInfo={courseInfo} 
        templateInfo={templateInfo}/>,templateForm);      
    }
    else {
      ReactDOM.render(<TemplateForm />,templateForm);
    }
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