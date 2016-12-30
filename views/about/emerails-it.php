<?php
	$this->set_title('Emeraldion Lodge - A proposito di EmeRails');
?>
<h2>A proposito di EmeRails</h2>
<p>
	<a href="https://github.com/emeraldion/emerails" class="external">EmeRails</a> è un framework per
	applicazioni web in PHP scritto attorno al febbraio 2008 e in seguito migliorato e esteso, ispirato a
	<a href="http://www.rubyonrails.org" class="external">Ruby on Rails</a>.
	Ha un'architettura <acronym title="Model View Controller">MVC</acronym>, uno strato
	<acronym title="Object Relational Mapping">ORM</acronym> paragonabile ad ActiveRecord, e separa la
	presentazione dalla logica di business in maniera elegante, dando la priorità alle convenzioni sulla
	configurazione.
</p>
<p>
	EmeRails supporta il caching delle pagine, i filtri delle azioni, e un sacco di altre utili funzionalità
	che risparmiano tempo di scrittura e risorse del server. EmeRails è disponibile su
	<a href="https://github.com/emeraldion/emerails" class="external">GitHub</a> sotto licenza
	<a href="http://opensource.org/licenses/MIT" class="external">MIT</a>. Sono attualmente impegnato a
	renderlo compatibile con i containers con <a href="https://docs.docker.com/engine/" class="external">Docker</a>.
</p>

<h3>Permettimi di mostrarti qualcosa</h3>
<ul>
	<li>
		<?php print a('Mostra questa pagina senza il markup di layout', array('href' => $this->url_to_myself() . '?nolayout')); ?>.
		Questo ti mostra come sono presentate le azioni.
	</li>
	<li>
		<?php print a('Mostra questa pagina convertita in codice Morse', array('href' => $this->url_to_myself() . '?hl=morse')); ?>.
		Questo ti mostra come si possono applicare filtri alla risposta prima che sia servita.
	</li>
</ul>
