import React from 'react';
import ReactDOM from 'react-dom';
import TemplateForm from './components/template.jsx';
import CompetencyFrameworkForm from './components/competency_framework_form.jsx';
/** mockups **/
import GradeTags from './components/mockups/grade_tags.jsx';
import SubjectTags from './components/mockups/subject_tags.jsx';
import SectionFieldsForm from './components/section.jsx';
import ContentNotesForm from './components/content_notes.jsx';
import TagsForm from './components/tags.jsx';
import FeedbackSwitchForm from './components/feedback_switch.jsx';

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

  var feedbackSwitchForm = document.querySelector('#feedback-switch');
  var contentId = $('#feedback-switch').attr('data-contentId');
  var sectionId = $('#feedback-switch').attr('data-sectionId');

  if (feedbackSwitchForm) {
    ReactDOM.render(<FeedbackSwitchForm 
    contentId={contentId} 
    sectionId={sectionId} 
    loadInfo={loadInfo}/>,feedbackSwitchForm);
  }

  var sectionForm = document.querySelector('#section-fields');
  var contentId = $('#section-fields').attr('data-contentId');
  var sectionId = $('#section-fields').attr('data-sectionId');
  var loadInfo = $('#section-fields').attr('data-loadInfo');

  if (sectionForm) {
    ReactDOM.render(<SectionFieldsForm 
    contentId={contentId} 
    sectionId={sectionId} 
    loadInfo={loadInfo}/>,sectionForm);
  }

  var notes = document.querySelector('#notes');
  var contentId = $('#notes').attr('data-contentId');
  var notesData = $('#notes').attr('data-notes');

  if (notes) {
    ReactDOM.render(<ContentNotesForm 
    contentId={contentId} 
    notes={notesData} 
    />,notes);
  }

  var tags = document.querySelector('#tags');
  var contentId = $('#tags').attr('data-contentId');
  var tagsData = $('#tags').attr('data-tags');

  if (tags) {
    ReactDOM.render(<TagsForm 
    contentId={contentId} 
    tags={tagsData} 
    />,tags);
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