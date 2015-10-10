<?php
	$this->set_title('Emeraldion Lodge - Servizi');
?>
<h2>Servizi</h2>
<p>
	Posseggo pi� di otto anni di esperienza nello sviluppo web.
	Quando iniziai, esisteva soltanto l&rsquo;HTML e delle strane immagini di sfondo ripetute.
	Da allora ho assistito alla nascita di linguaggi, standard, strumenti e mode.
	Queste cose passano.
	Ci� che davvero importa � una progettazione orientata ai requisiti,
	pratiche di programmazione ottime e l&rsquo;uso di standard solidi e aggiornati.
</p>

<h2>Sviluppo per il Web</h2>
<p>
	I miei servizi spaziano dalla progettazione e lo sviluppo da zero di applicazioni web
	per le PMI, siti internet/intranet aziendali o personali, allo sviluppo di soluzioni software personalizzate.
	Sono molto ferrato nello sviluppo LAMP, padroneggio Javascript con eccellente abilit� in AJAX.
	Il mio linguaggio principale per il web � il PHP, ma non disdegno altre tecnologie come Java, Ruby etc.
</p>

<h2>Sviluppo software Cocoa</h2>
<p>
	Sono particolarmente bravo nello sviluppo Cocoa per il Mac. Dal 2005 ad oggi, ho scritto pi� di 10.000
	linee di codice che gira ogni giorno su pi� di <?php
	
		$count = SoftwareArtifact::total_downloads();
		$count_rounded = 1000 * floor($count / 1000);
		print number_format($count_rounded, 0, ',', '.');
	
	?> computer Macintosh<sup>(<a href="#note-1">1</a>)</sup> in ogni parte del mondo.
	Se hai bisogno di consulenza sullo sviluppo di applicazioni Cocoa per il Mac, potrei essere la persona giusta per te.
</p>

<h2>Localizzazione italiana</h2>
<p>
	Ho gi� coordinato ed effettuato la localizzazione di svariate applicazioni da me sviluppate, ed
	inoltre ho contribuito a localizzare applicazioni di terzi in Italiano. Se avete bisogno di aiuto per localizzare la vostra
	applicazione in Italiano, sar� lieto di aiutarvi.
</p>


<ol id="footnotes">
	<li id="note-1">Stima basata sul numero totale di download del software da maggio 2005.</li>
</ol>

<?php
	//print $this->render_component(array('controller' => 'portfolio', 'action' => 'latest_works'));
?>