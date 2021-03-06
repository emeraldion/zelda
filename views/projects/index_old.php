<?php
  $this->set_title('Emeraldion Lodge - ' . l('Projects'));
?>
<h2>Projects</h2>
<ul>
  <li><a href="#adelia">Adelia</a> &ndash; A simple promise-based ORM for Node, loosely inspired to ActiveRecord.</li>
  <li><a href="#emerails">EmeRails</a> &ndash; A lightweight Rails-like web application framework and ORM written in PHP.</li>
  <li><a href="#guidatv">GuidaTV</a> &ndash; EPG application for Italian TV channels.</li>
  <li><a href="#learn-sass">learn-sass</a> &ndash; Learn SASS and SCSS through a workshopper adventure.</li>
  <li><a href="#mbl">MiniBatteryLogger</a> &ndash; A Mac OS X application designed to monitor the battery and log all power events.</li>
  <li><a href="#mbl-archive">MiniBatteryLogger Shared Battery Data Archive</a> &mdash; A collection of battery stats, organized by computer and battery model, produced by MiniBatteryLogger.</li>
  <li><a href="#project-mandarine">Project Mandarine</a> &mdash; A simple game implemented as a single-page JS application.</li>
  <li><a href="#project-mandarine-cocoa">Project Mandarine Cocoa</a> &mdash; A simple Cocoa + WebKit wrapper around the Project Mandarine game.</li>
  <li><a href="#websms">WebSMS</a> &mdash; A widget to send free SMS messages through carriers&rsquo; web sites in a convenient way.</li>
</ul>


<a name="adelia"></a>
<h2><a target="_blank" href="https://github.com/emeraldion/adelia">Adelia</a></h2>
<h4>A simple promise-based ORM for Node, loosely inspired to ActiveRecord.</h4>
<p>
  Adelia is meant to be a fast, simple, promise-based ORM for Node, loosely inspired
  to Martin Fowler's <a href="http://www.martinfowler.com/eaaCatalog/activeRecord.html">ActiveRecord</a>
  pattern popularized by <a href="http://rubyonrails.org/">Ruby on Rails</a>.
  Due to the async IO nature of Node and DB clients, the API must be async.
  Adelia uses <a href="https://promisesaplus.com/">Promises</a> to offer a clean,
  uncluttered API that's easy to compose and reason about.
</p>
<p>
  Check out the source code on the
  <a href="https://github.com/emeraldion/adelia" target="_blank">GitHub repo</a>,
  and <a href="https://travis-ci.org/emeraldion/adelia" target="_blank">Travis CI tests</a>.
</p>
<div class="lighter">
  Tags: JavaScript, ORM, Node, Promises, Bluebird, MySQL, ActiveRecord.
</div>


<a name="emerails"></a>
<h2><a target="_blank" href="//emerails.emeraldion.it">EmeRails</a></h2>
<h4>A lightweight Rails-like web application framework and ORM written in PHP.</h4>
<p>
  A few years ago I wrote a lightweight clone of Ruby on Rails, by replicating much
  of the ActiveRecord model class, and a convention-based MVC development model.
  I struggled against the syntactical and practical limitations of the PHP language,
  but at the end I had a working framework in less than a month.
  EmeRails supports page caching, action filtering and a lot of useful features
  that save coding time and server load.
</p>
<p>
  Check out the <a href="//emerails.emeraldion.it" target="_blank">Demo instance</a>,
  the <a href="//emerails.emeraldion.it/docs.html" target="_blank">Documentation</a>,
  and the source code on the
  <a href="https://github.com/emeraldion/emerails" target="_blank">GitHub repo</a>.
</p>
<div class="lighter">
  Tags: Web Application Framework, ORM, PHP, MySQL, ActiveRecord.
</div>


<a name="guidatv"></a>
<h2><a target="_blank" href="/software/macosx/guidatv.html">GuidaTV</a></h2>
<h4>EPG application for Italian TV channels.</h4>
<p>
  GuidaTV is an <acronym title="Electronic Program Guide">EPG</acronym> application meant to provide exhaustive
  listing and review of the programs aired on &mdash; but not necessarily limited to &mdash;
  Italian terrestrial and satellite TV channels.
</p>
<p>
  Check out the <a target="_blank" href="/software/macosx/guidatv.html">Application</a>
  and the source code on the
  <a href="https://github.com/emeraldion/guidatv" target="_blank">GitHub repo</a>.
</p>
<div class="lighter">
  Tags: Cocoa, Mac OS X, EPG, TV.
</div>


<a name="learn-sass"></a>
<h2><a target="_blank" href="https://npmjs.org/package/learn-sass">learn-sass</a></h2>
<h4>Learn SASS and SCSS through a workshopper adventure.</h4>
<p>
  Teach yourself the basics of SASS and SCSS through simple coding exercises.
  Based on the node workshopper adventure format popularized by
  <a target="_blank" href="http://nodeschool.io/">NodeSchool</a>.
  This adventure utilizes tutorials from the awesome
  <a target="_blank" href="http://sass-lang.com/guide">Sass guide</a>.
</p>
<p>
  Check out the <a target="_blank" href="https://npmjs.org/package/learn-sass">NPM module</a>
  and the source code on the
  <a href="https://github.com/claudiopro/learn-sass" target="_blank">GitHub repo</a>.
</p>
<div class="lighter">
  Tags: NodeSchool, Node, JavaScript, Sass, SCSS, Workshopper, Community, Learning, Education.
</div>


<a name="mbl"></a>
<h2><a target="_blank" href="/software/macosx/minibatterylogger.html">MiniBatteryLogger</a></h2>
<h4>A Mac OS X application designed to monitor the battery and log all power events.</h4>
<p>
  MiniBatteryLogger is a Mac OS X application that monitors laptop batteries,
  traces the graph of charge and current over time, compares and rates the performance
  of batteries among users, logs all power events and alerts the user with Growl notifications.
  Since I am not currently maintaining this project, I released it as open source so people
  can contribute and add support for new models and recent OSs.
</p>
<p>
  Check out the <a href="/software/macosx/minibatterylogger.html" target="_blank">Application</a>,
  and the source code on the
  <a href="https://github.com/emeraldion/minibatterylogger" target="_blank">GitHub repo</a>.
</p>
<div class="lighter">
  Tags: Cocoa, Mac OS X, Monitoring, Energy, Power, Battery.
</div>


<a name="mbl-archive"></a>
<h2><a target="_blank" href="http://burgos.emeraldion.it/mbl/">MiniBatteryLogger Shared Battery Data Archive</a></h2>
<h4>A collection of battery stats, organized by computer and battery model, produced by MiniBatteryLogger.</h4>
<p>
  The Shared Battery Data Archive is a collection of battery statistics, organized by computer model, for Apple
  Macintosh laptop computers. It is a free resource for anybody to lookup, to evaluate the performance of own
  batteries, to elaborate statistics on battery life, power consumption, etc. Data is presented hierarchically.
  You can browse the list of models, which shows the number of available entries grouped by computer model,
  and then choose a particular model to browse all the actual entries.
</p>
<p>
  Check out the <a target="_blank" href="http://burgos.emeraldion.it/mbl/">Archive</a>.
</p>
<div class="lighter">
  Tags: Service, Monitoring, Energy, Power, Battery.
</div>


<a name="project-mandarine"></a>
<h2><a target="_blank" href="https://emeraldion.github.io/project-mandarine/">Project Mandarine</a></h2>
<h4>A simple game implemented as a single-page JS application.</h4>
<p>
  Project Mandarine is a simple 2D game implemented with JavaScript. Sprites were hand drawn (sigh!)
  and acquired with a scanner. The game location is a classroom at my high school :-).
</p>
<p>
  Check out the source code on the
  <a href="https://github.com/emeraldion/project-mandarine" target="_blank">GitHub repo</a>.
</p>
<div class="lighter">
  Tags: JavaScript, Game, Fun.
</div>


<a name="project-mandarine-cocoa"></a>
<h2><a target="_blank" href="/software/macosx/project_mandarine.html">Project Mandarine Cocoa</a></h2>
<h4>A simple Cocoa + WebKit wrapper around the Project Mandarine game.</h4>
<p>
  A native Cocoa application wrapper around the Project Mandarine game, rendering the JS application in a WebKitView.
</p>
<p>
  Check out the <a href="/software/macosx/project_mandarine.html" target="_blank">Application</a>,
  and the source code on the
  <a href="https://github.com/emeraldion/project-mandarine-cocoa" target="_blank">GitHub repo</a>.
</p>
<div class="lighter">
  Tags: Cocoa, WebKit, Mac OS X, JavaScript, Game, Fun.
</div>


<a name="websms"></a>
<h2><a target="_blank" href="/software/widgets/websms.html">WebSMS</a></h2>
<h4>A widget to send free SMS messages through carriers&rsquo; web sites in a convenient way.</h4>
<p>
  WebSMS automates the tedious task of sending free text messages through the carriers&rsquo; websites,
  which often require authenticating and clicking through a few pages. It is integrated with the
  Address Book with autocompletion for easy access to recipients, and securely stores account passwords
  in the system Keychain.
</p>
<p>
  Check out the <a href="/software/widgets/websms.html" target="_blank">Widget</a>,
  and the source code on the
  <a href="https://github.com/emeraldion/websms" target="_blank">GitHub repo</a>.
</p>
<div class="lighter">
  Tags: Dashboard, Texting, Mac OS X, JavaScript, Utility.
</div>
