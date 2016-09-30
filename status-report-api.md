---
layout: page
title: Status Report API
weight: 10
---

<p>The Status Report API provides the data to access and analyze content created including review scores. This data may be used on its own or combined with other data to create reports or for other actions such as issuing Open Badges. The data in the report contains:</p>

<ul>
<li>id of the content</li>
<li>title</li>
<li>link to the content</li>
<li>created_at - when the content was created</li>
<li>updated_at - when the content was last updated</li>
<li>status- edit or published</li>
<li>reviews - comments, scores and created_at for all reviews for the content</li>
<li>user - id and name of the content author</li>
</ul>

<p>The Status Report API currently assumes that the Process Lab is being used as a plugin for another system and requires the LTI Consumer Name and Secret. However, as long as the Consumer Name and Secret are entered in settings, these credentials can be used to access the API even if the Process Lab is being used as a stand-alone system.</p>
