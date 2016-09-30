---
layout: page
title: LTI Requirements
weight: 11
---

<p>The Process Lab uses LTI to authorize platforms and send user data. Read the <a href="https://www.imsglobal.org/specs/ltiv1p0" target="_blank">specifications</a> provided by IMS Global.</p>

<table>
<thead>
  <tr>
     <th>Parameter</th>
     <th>#Explanation/Example Data</th>
     <th>Required</th>
  </tr>
 </thead>

 <tbody>
 <tr>
 <td>lti_message_type</td>
 <td>basic-lti-launch-request</td>
 <td>yes</td>
 </tr>
  <tr>
 <td>lti_version</td>
 <td>LTI-1p0</td>
 <td>yes</td>
 </tr>
 <tr>
 <td>launch_presentation_document_target</td>
 <td>frame</td>
 <td></td>
 </tr>
  <tr>
 <td>launch_presentation_width</td>
 <td>550</td>
 <td></td>
 </tr>
 <tr>
 <td>launch_presentation_height</td>
 <td>300</td>
 <td></td>
 </tr>
 <tr>
 <td>launch_presentation_return_url</td>
 <td>#URL for consumer site</td>
 <td>yes</td>
 </tr>
 <tr>
 <td>launch_presentation_css_url</td>
 <td>#URL for CSS on consumer site</td>
 <td></td>
 </tr>
 <tr>
 <td>launch_presentation_locale</td>
 <td>en-US</td>
 <td></td>
 </tr>
 <tr>
 <td>lis_person_sourcedid</td>
 <td>school.edu:user</td>
 <td></td>
 </tr>
 <tr>
 <td>lis_result_sourcedid</td>
 <td>feb-123-456-2929::28883</td>
 <td></td>
 </tr>
 <tr>
 <td>user_id</td>
 <td>5556 #user id on consumer site</td>
 <td>yes</td>
 </tr>
 <tr>
 <td>lis_person_name_full</td>
 <td>Jane Test</td>
 <td>yes</td>
 </tr>
  <tr>
 <td>lis_person_contact_email_primary</td>
 <td>janetest@email.com</td>
 <td>yes</td>
 </tr>
  <tr>
 <td>roles</td>
 <td>Instructor,Mentor, Mentor/Reviewer
 <br/>
 # roles are specified by LTI but are named differently in Process Lab. Translation:<br/>
learner = author (default)<br/>
administrator = admin<br/>
mentor = online facilitator<br/>
instructor = peer reviewer<br/>
mentor/reviewer = expert reviewer</td>
 <td></td>
 </tr>
  <tr>
 <td>user_image</td>
 <td>#URL for user profile image on consumer site</td>
 <td>yes</td>
 </tr>
 <tr>
 <td>context_id</td>
 <td>Chem-101.78914 #course user is taking on consumer site</td>
 <td></td>
 </tr>
  <tr>
 <td>context_label</td>
 <td>CHEM101</td>
 <td></td>
 </tr>
 <tr>
 <td>context_title</td>
 <td>Chemistry 101</td>
 <td></td>
 </tr>
 <tr>
 <td>context_type</td>
 <td>CourseSection</td>
 <td></td>
 </tr>
 <tr>
 <td>resource_link_description</td>
 <td>A weekly blog</td>
 <td></td>
 </tr>
 <tr>
 <td>resource_link_id</td>
 <td>937267789</td>
 <td>yes</td>
 </tr>
 <tr>
 <td>resource_link_title</td>
 <td>Weekly Blog</td>
 <td></td>
 </tr>
  <tr>
 <td>tool_consumer_info_product_family_code</td>
 <td>123ABC</td>
 <td></td>
 </tr>
  <tr>
 <td>tool_consumer_info_version</td>
 <td>1.0</td>
 <td></td>
 </tr>
  <tr>
 <td>tool_consumer_instance_description</td>
 <td>University or School</td>
 <td></td>
 </tr>
   <tr>
 <td>tool_consumer_instance_guid</td>
 <td>http://consumersite.com #domain of consumer site</td>
 <td></td>
 </tr>
 <tr>
 <td>oauth_consumer_key</td>
 <td>#consumer key defined by consumer site</td>
 <td>yes</td>
 </tr>
  <tr>
 <td>oauth_timestamp</td>
 <td>#consumer secret defined by consumer site</td>
 <td>yes</td>
 </tr>
   <tr>
 <td>oauth_version</td>
 <td>1.0</td>
 <td></td>
 </tr>
 <tr>
 <td>oauth_nonce</td>
 <td></td>
 <td>yes</td>
 </tr>
  <tr>
 <td>oauth_callback</td>
 <td></td>
 <td>yes</td>
 </tr>
  <tr>
 <td>oauth_signature_method</td>
 <td></td>
 <td>yes</td>
 </tr>
   <tr>
 <td>oauth_signature</td>
 <td></td>
 <td>yes</td>
 </tr>
 <tr>
 <td>custom_user_tag_school</td>
 <td>#custom defined tag with label. To define a custom tag with label follow this pattern:<br/>

customer_user_tag_[label]<br/><br/>

Example:<br/>
Custom_user_tag_school = Texas Elementary School</td>
 <td></td>
 </tr>
    <tr>
 <td>custom_user_tags</td>
 <td>Comma-delimited string of tags for the user. Example:<br/>
Spanish,math, esl</td>
 <td></td>
 </tr>
   <tr>
 <td>custom_tc_profile_url</td>
 <td></td>
 <td>#users profile on consumer site</td>
 </tr>
</tbody>

</table>