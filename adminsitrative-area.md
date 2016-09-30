---
layout: page
title: Administrative Area
weight: 6
---

<p>The Administrative Area controls the basic settings of the site. Here site settings, users, tags, templates & competencies may be managed.</p>
 
<h4>Manage Site Settings</h4>
<p>In this area the base site settings may be edited. This primarily includes the Site Title and LTI/API credentials. In this area the Competency Framework Value Labels may be set. There are four labels, each representing the column of the site’s rubric values. Each label count refers also the points for each column. For instance, Label 1 is for column 1 and competencies listed in this column have a point of 1, same goes for Label 2, Label 3 and Label 4. An example of these column values is:</p>

<ul>
<li>Label 1: Developing (1 point)</li>	
<li>Label 2: Proficient (2 points)</li>
<li>Label 3: Accomplished (3 points)</li>
<li>Label 4: Distinguished (4 points)</li>
</ul>

<h4>Manage Users</h4>
<p>There are two main uses for the manage users administrative area:</p>

<ol>
<li>Add new users: New users may be added by clicking on the “Add New User” button. All fields are required except for Profile Url and User Tags.</li>
<li>Edit roles of users</li>
</ol>

<p>At this time, user names and emails can’t be edited in the system. Important note: Initially the application was created as a plugin. This means that it expects user data to be created and updated via LTI. In the future more functionality to edit users may be added.</p>

<h4>Manage Tags</h4>
<p>There are two main different types of tags:</p>
<ol>
<li>user: tags added when a user is created or via LTI</li>
<li>content: tags added when creating templates (future use) and creating content (used when searching for published resources)</li>
</ol>

<p>Tags may be edited but not yet deleted (future functionality). Tags may also be created. To create a tag, click on “Add New Tag” button. Choose whether the tag is a user or content tag and add the tag. The new tag won’t be associated with a user or content until it is chosen in those contexts.</p>

<h4>Manage Templates</h4>
<p>Templates are the base for all content created on Process Labs. Before creating content, at least one template must be created. Click on the “Add New Template” button to get started.</p>

<p>All required fields are marked with a red asterisk (*). The form will auto-save. Note: A Title is required before all of the other fields.</p>

<ul>
<li>Title: The name of the template.</li>
<li>Description: A short description of the template’s objective</li>
<li>Course Information: This allows the template to be linked to a specific course.</li>
<li>Course Id: Unique id of the course</li>
<li>Title: Name of the course</li>
<li>URL: link to the course</li>
<li>Template Tags: add tags to search for templates (future functionality)</li>
<li>Sections and Fields: Content may be separated into multiple sections and each section may have multiple fields. Fields may be marked as required.</li>
<li>Rubric Scores and Values: To align content to rubrics for authors and for reviewers, add the framework, competencies and descriptions here. To add a rubric, first add a Competency Framework.</li>
</ul>

<h4>Manage Competency Frameworks</h4>
<p>This area of the admin is to create and edit competency frameworks for use in templates to add rubrics for content and reviews. To add a new framework, click the “Add New Framework” button. Name the framework and add as many categories as are needed to generate the rubric. This competency framework may be used for multiple templates. At this time frameworks may be edited but not deleted (future functionality).</p>