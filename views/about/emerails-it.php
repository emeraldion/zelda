<?php
	$this->set_title("Emeraldion Lodge - Informazioni su EmeRails");
?>
<div class="navbox">
	<div class="clear"></div>

	<div style="float: left; width: 290px; text-align:center">
		<img src="/assets/images/about/emerails_code_snippet.png"
			style="margin: 20px 0 0 0"
			alt="Frammento di codice sorgente di EmeRails"
			title="Frammento di codice sorgente di EmeRails" />
		<p class="caption">Foto: ???</p>
	</div>
	<div style="margin: 0 20px 0 310px">
		<h2>
			Informazioni su EmeRails
		</h2>
		<p>
			A met&agrave; di Febbraio 2008, divenni insoddisfatto del mio attuale framework fatto in casa utilizzato
			per la Emeraldion Lodge, EmePavilion. Sentii il bisogno per una solida piattaforma di sviluppo che
			fosse orientata ad oggetti<sup>(<a href="#note1">1</a>)</sup>, pienamente
			conforme al paradigma <acronym title="Model View Controller">MVC</acronym>, e avesse uno strato
			<acronym title="Object Relational Mapping">ORM</acronym> che mi sollevasse dal dovere includere nel
			codice dell&rsquo;applicazione ripetitivi schemi di query SQL.
		</p>
		<p>
			Mi cimentai quindi nell&rsquo;impresa di scrivere da zero un clone leggero di
			<a href="http://www.rubyonrails.org" class="external">Ruby on Rails</a>,
			replicando molte funzioni della classe modello ActiveRecord, e utilizzando un modello di sviluppo basato sulle convenzioni
			anzich&eacute; sulla configurazione.
			Ho lottato<sup>(<a href="#note2">2</a>)</sup> contro le limitazioni sintattiche e pratiche
			del linguaggio al quale sono vincolato dal mio hosting,
			<a href="http://www.php.net" class="external">PHP</a>,
			ma alla fine mi ritrovai un framework funzionante in meno di un mese.
		</p>
		<p>
			EmeRails supporta il caching delle pagine, filtri per le azioni, localizzazione e un sacco di altre utili funzionalit&agrave;
			che risparmiano tempo di sviluppo e carico del server.
			Sono abbastanza soddisfatto del risultato, e ho intenzione di migliorarlo e smussarne i contorni ancora grezzi
			in futuro, e perch&eacute; no, magari anche rilasciarlo al pubblico prima o poi.
		</p>
		<ol id="notes">
			<li class="lighter" id="note1">
				EmePavilion era infatti scritto in vecchio codice procedurale PHP4.
			</li>
			<li class="lighter" id="note2">
				Tre settimane di <em>coding</em> matto e disperatissimo.
			</li>
		</ol>
		
		<h3>Un po&rsquo; di scena!</h3>
		<ul>
			<li>
				<?php print a('Mostra questa pagina senza codice HTML di layout', array('href' => $this->url_to_myself() . '?nolayout')); ?>.
				Questo dimostra il meccanismo di rendering delle azioni.
			</li>
			<li>
				<?php print a('Mostra questa pagina in codice Morse', array('href' => $this->url_to_myself() . '?hl=morse')); ?>.
				Questo dimostra come i filtri possano essere applicati alla risposta prima che sia servita al client.
			</li>
			<li>
				<?php print a('Mostra questa pagina in &ldquo;Sanscrito&rdquo;', array('href' => $this->url_to_myself() . '?hl=sanskrit')); ?>
				(alla maniera di Ambra in &ldquo;Non &egrave; la Rai&rdquo;).
				Un&rsquo;altra dimostrazione di un filtro personalizzato applicato alla risposta generata.
			</li>
		</ul>
		<p>
			Pss: questa pagina viene compressa con codifica <code>gzip</code> prima di essere restituita al browser (se questi
			la supporta) per risparmiare banda.
		</p>
	</div>
	<div class="clear"></div>
</div>