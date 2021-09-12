@extends('vendor.upepo.admin.layouts.master')
@section('section-title') AJUTOR @endsection
@section('section-content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

<style type="text/css">
	span.ajutor>*{font-size: 18px}
	.pt-30 {padding-top: 30px;}
	.pb-30 {padding-bottom: 30px;}
	.p-30 {padding-top: 30px;padding-bottom: 30px;}
	.m-60 {margin-top: 60px;margin-bottom: 60px;}
</style>

<h1 class="text-left pb-30">PANOUL DE ADMINISTRARE <br><small>Ghid de utilizare</small></h1>

<span class="ajutor">
	<h2>PAGINI</h2>
	<ul>
		<li><a href="{{url('admin/help#tipuri')}}">Tipuri de pagini</a>
			<ul>
				<li><a href="{{url('admin/help#statice')}}">Pagini statice</a></li>
				<li><a href="{{url('admin/help#dinamice')}}">Pagini dinamice</a></li>
			</ul>
		</li>
		<li><a href="{{url('admin/help#butoane')}}">Butoanele unei pagini</a>
			<ul>
				<li><a href="{{url('admin/help#btn_add')}}">Adăugare înregistrare</a></li>
				<li><a href="{{url('admin/help#btn_del')}}">Ştergere înregistrare</a></li>
				<li><a href="{{url('admin/help#btn_ord')}}">Ordonare înregistrări</a></li>
				<li><a href="{{url('admin/help#btn_nr')}}">Număr înregistrări / pagină</a></li>
			</ul>
		</li>
		<li><a href="{{url('admin/help#inregistrari')}}">Înregistrări - opţiuni</a>
			<ul>
				<li><a href="{{url('admin/help#reg_edit')}}">Editare</a></li>
				<li><a href="{{url('admin/help#reg_del')}}">Ștergere</a></li>
				<li><a href="{{url('admin/help#reg_img')}}">Adăugare imagini</a></li>
				<li><a href="{{url('admin/help#reg_file')}}">Adăugare fişiere</a></li>
			</ul>
		</li>
		<li><a href="{{url('admin/help#editor')}}">Editorul - utilizare</a></li>
	</ul>
	<h2 class="pt-30">SETARI</h2>
    <ol>
    	<li><a href="{{url('admin/help#map')}}">Hartă</a></li>
    	<li><a href="{{url('admin/help#generale')}}">Setări generale</a></li>
    	<li><a href="{{url('admin/help#sociale')}}">Reţele sociale</a></li>
    	<li><a href="{{url('admin/help#sitemap')}}">Sitemap</a></li>
    </ol>
    <hr class="m-60">
    <div id="tipuri">
    	<h3 class="text-success">Tipuri de pagini</h3>
    	<p>Diferitele secțiuni (sau pagini) ale site-ului se află în meniul principal (stânga ecranului), sub titlul <em>PAGINI</em>.</p>
    	<p>Există două tipuri de pagini:</p>
    	<ul>
    		<li id="statice"><strong>Statice</strong> - care conțin o singură înregistrare (ex. <em>Contact</em>, <em>Despre noi</em> etc.). Acestor tipuri de pagini nu li se pot adăuga alte înregistrări.</li>
    		<li id="dinamice"><strong>Dinamice</strong> - cărora li se pot adăuga mai multe înregistrări (ex. <em>Produse</em>, <em>Articole</em>, <em>Noutati</em> etc.)</li>
    	</ul>
    </div>
    <hr>
    <div id="butoane">
    	<h3 class="text-success">Butoanele unei pagini</h3>
    	<p>O pagină poate avea următoarele butoane:</p>
    	<table class="table">
    		<thead>
    			<tr>
    				<th>Buton</th>
    				<th>Descriere</th>
    			</tr>
    		</thead>
    		<tr id="btn_add">
    			<td class="text-left">
    				<a class="btn btn-primary btn-small" href="javascript:void(0)"><i class="fa fa-plus-circle"></i> Adauga [un element]</a>
    			</td>
    			<td>Pentru adăugarea unei noi înregistrări. Butonul apare pe paginile dinamice.</td>
    		</tr>
    		<tr id="btn_ord">
				<td class="text-left"><button type="button" class="btn btn-success btn-sm" value="1"><i class="fa fa-reorder"></i> Schimba ordinea</button></td>
    			<td>Ordonare înregistrări. Apăsaţi acest buton după ce aţi modificat cifra/cifrele care indică ordinea unei/mai multor înregistrări (coloana <em>Ordine</em>).</td>
    		</tr>
    		<tr id="btn_del">
    			<td class="text-left"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button></td>
    			<td>Ștergere înregistrări multiple. Apăsați acest buton după ce aţi selectat mai multe înregistrări afișate, sau pe toate (selecția se face bifând căsuţele din prima coloană).</td>
    		</tr>
    		<tr id="btn_nr">
    			<td>
    				<div class="input-group">
				        <span class="input-group-btn">
				            <button type="button" class="btn btn-primary btn-sm">Arata:</button>
				        </span>
				        <input style="max-width:60px;" class="form-control input-sm" min="5" name="perPage" type="number" value="10">
				    </div>
    			</td>
    			<td>Selectare număr înregistrări afişate pe pagină. Minim 5. Click pe <em>Arata</em> după ce aţi selectat numărul.</td>
    		</tr>
		</table>
    </div>
    <hr>
    <div id="inregistrari">
    	<h3 class="text-success">Înregistrări</h3>
    	<p>Fiecare înregistrare listată, în funcţie de specificul paginii căreia îi aparţine, poate prezenta următoarele opţiuni:</p>

    	<table class="table">
    		<thead>
    			<tr>
    				<th>Simbol</th>
    				<th>Descriere</th>
    			</tr>
    		</thead>
    		<tr id="reg_edit">
    			<td><a href="javascript:void(0)" class="panelIcon editItem"></a></td>
    			<td>Editare înregistrare. Deschide o pagină pentru editarea înregistrării respective.</td>
    		</tr>
    		<tr id="reg_del">
    			<td><a href="javascript:void(0)" class="panelIcon deleteItem"></a></td>
    			<td>Ştergere înregistrare. O fereastră vă va cere să confirmaţi ştergerea definitivă.</td>
    		</tr>
    		<tr id="reg_img">
    			<td><a href="javascript:void(0)" class="panelIcon addImage"></a></td>
    			<td>
					<p>Adăugare imagini; numărul de poze care pot fi adăugate este prestabilit.</p>
    				<p>După ce aţi dat click pe iconiţă şi s-a deschis pagina:</p>
    				<ol>
    					<li><strong>Titlu poza</strong> (facultativ) - Titlul pozei; opţiunea are efect doar pentru anumite site-uri;</li>
    					<li><strong>Alege o poza</strong> - Click pe <em>Răsfoieşte</em> şi selectaţi poza dorită din calculatorul personal;</li>
    					<li><strong>Adauga poza</strong> - Daţi click pe acest buton pentru a salva poza pe site.</li>
    				</ol>
    				<p>Ulterior, pozelor adăugate li se va putea modifica titlul, ordinea, sau vor putea fi şterse.</p>
    			</td>
    		</tr>
    		<tr id="reg_file">
    			<td><a href="javascript:void(0)" class="panelIcon file"></a></td>
    			<td>
				<p>Adăugare fişiere; numărul de fişiere care pot fi adăugate este prestabilit.</p>
    			<p>După ce aţi dat click pe iconiţă şi s-a deschis pagina:</p>
    				<ol>
    					<li><strong>Nume fişier</strong> - maxim 50 caractere;</li>
    					<li><strong>Alege un fişier</strong> - Click pe <em>Răsfoieşte</em> şi selectaţi fişierul dorit din calculatorul personal;</li>
    					<li><strong>Adauga fişier</strong> - Daţi click pe acest buton pentru a salva fişierul pe site.</li>
    				</ol>
				</td>
    		</tr>
    	</table>
    </div>
    <hr>
    <div id="editor">
    	<h3 class="text-success">Editorul - utilizare</h3>
    	<table class="table">
    		<thead>
    			<tr>
    				<th style="width: 100px">Icon</th>
    				<th>Funcţie</th>
    				<th>Cum se procedeaza?</th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr><td><span class="ckedit ckedit-link"></span></td><td><u>Link-uri & Fişiere</u></td><td>
    				<p><strong>Creare Link</strong>:</p>
    				<ol>
    					<li>Selectaţi tab-ul <em>Informaţii despre link (Legătură web)</em> şi completaţi câmpurile de mai jos;</li>
    					<li><u>Display Text</u> - denumirea link-ului, aşa cum va apărea pe pagină;</li>
    					<li><u>Tipul link-ului</u> - trebuie să fie "URL" (este presetat, nu modificaţi);</li>
    					<li><u>Protocol</u> - alegeţi între <em>http://</em> şi <em>https://</em> ;</li>
    					<li><u>URL</u> - completaţi adresa paginii (ceea ce urmează după <em>http://</em> sau <em>https://</em>). De ex.: <em>www.mysite.ro</em>;</li>
    					<li><u>OK</u> - salvare link.</li>
    				</ol>
    				<p><strong>Adăugare Fişier</strong> - există 2 scenarii posibile:</p>
    				<ol type="A">
    					<li><em>Fişierul există deja pe server</em>
    					<ol>
    						<li>Selectaţi tab-ul <em>Informaţii despre link (Legătură web)</em> ;</li>
    						<li><u>Răsfoieşte server</u> - apăsaţi acest buton pentru a selecta unul dintre fişierele existente pe server;</li>
    						<li>Daţi click pe fişierul dorit;</li>
    						<li><u>Display Text</u> - completaţi cu denumirea dorită, aşa cum va apărea pe pagină;</li>
    						<li><u>OK</u> - click pentru a salva.</li>
    					</ol>
    					</li>
    					<li><em>Fişierul NU există pe server (adăugare fişier nou)</em>
    						<ol>
    						<li>Selectaţi tab-ul <em>Încarcă</em> ;</li>
    						<li><u>Răsfoieşte...</u> - apăsaţi pentru a selecta un fişier din calculatorul personal;</li>
    						<li>Selectaţi fişerul dorit şi apăsaţi <em>Open</em>;</li>
    						<li><u>Trimite la server</u> - click pentru a încărca fişierul pe server;</li>
    						<li><u>Display Text</u> - completaţi cu denumirea dorită, aşa cum va apărea pe pagină;</li>
    						<li><u>OK</u> - click pentru a salva.</li>
    					</ol>
    					</li>

    				</ol>

    			</td></tr>
    			<tr><td><span class="ckedit ckedit-image"></span></td><td><u>Imagini</u></td><td>
    				<p>Pentru inserarea unei poze în editor:</p>
    				<ol type="A">
    					<li><strong>Adăugare poză nouă</strong>
    						<ol>
    							<li>Poziţionaţi cursorul în locul unde doriţi să inseraţi poza;</li>
    							<li>Click pe <span class="ckedit ckedit-image inline-icon"></span> ;</li>
    							<li>Selectaţi tab-ul <em>Încarcă</em> ;</li>
    							<li><u>Răsfoieşte...</u> - apăsaţi pentru a selecta o poză din calculatorul personal;</li>
    							<li>Selectaţi poza dorită şi apăsaţi <em>Open</em>;</li>
    							<li><u>Trimite la server</u> - click pentru a încărca poza pe server;</li>
    							<li id="setari_facultative">Setări facultative disponibile
    								<ul>
    									<li><strong>Lăţime & Înălţime</strong> - completaţi cu valorile dorite;</li>
    									<li><strong>Margine</strong> - introduceţi un număr care va reprezenta grosimea în pixeli a chenarului din jurul pozei;</li>
    									<li><strong>HSpace & VSpace</strong> - Spaţiul orizontal şi, respectiv, cel vertical din jurul imaginii; valorile numerice sunt calculate în pixeli;</li>
    									<li><strong>Aliniere</strong>.</li>
    								</ul>
    							</li>
    						</ol>
    					</li>
    					<li><strong>Poza există deja pe server</strong>
    						<ol>
    							<li>Poziţionaţi cursorul în locul unde doriţi să inseraţi poza;</li>
    							<li>Click pe <span class="ckedit ckedit-image inline-icon"></span> ;</li>
    							<li>Selectaţi tab-ul <em>Informaţii despre imagine</em> ;</li>
    							<li><u>Răsfoieşte server</u> - apăsaţi pentru a selecta o poză existentă pe server;</li>
    							<li>Faceţi <a href="#setari_facultative">setările facultative</a> şi salvaţi.</li>
    						</ol>
    					</li>

    				</ol>
    			</td></tr>
    			<tr><td><span class="ckedit ckedit-table"></span></td><td><u>Tabel</u></td><td>
    				<p><strong>Creare tabel nou</strong>:<p>
    					<ol>
    						<li>Poziţionaţi cursorul în locul unde doriţi să inseraţi tabelul;</li>
    						<li>Click pe <span class="ckedit ckedit-table inline-icon"></span> ;</li>
    						<li>Setaţi proprietăţile noului tabel.</li>
    						<li><u>OK</u> - click pentru a salva.</li>
    					</ol>
					<p><strong>Editare tabel existent</strong>:</p>
						<ol>
							<li>Selectaţi tabelul;</li>
							<li>Click dreapta & selectaţi una dintre opţiuninile disponibile (Celulă, Rând, Coloană, Proprietăţile tabelului).</li>
							<li><u>OK</u> - click pentru a salva.</li>
						</ol>
    			</td></tr>
    			<tr><td><span class="ckedit ckedit-numberedlist"></span></td><td><u>Listă numerotată</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-bulletedlist"></span></td><td><u>Listă simplă</u></td><td></td></tr>

    			<tr><td><span class="ckedit ckedit-justifyblock"></span></td><td><u>Aliniere</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-justifycenter"></span></td><td><u>Aliniere centrată</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-justifyleft"></span></td><td><u>Aliniere la stanga</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-justifyright"></span></td><td><u>Aliniere la dreapta</u></td><td></td></tr>

    			<tr><td><span class="ckedit ckedit-bgcolor"></span></td><td><u>Culoare fundal text</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-textcolor"></span></td><td><u>Culoare font</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-specialchar"></span></td><td><u>Caracter special</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-removeformat"></span></td><td><u>Anulează formatarea</u></td><td></td></tr>
    			<tr><td><span class="ckedit ckedit-maximize"></span></td><td><u>Full screen</u></td><td></td></tr>
    		</tbody>
    	</table>

    </div>
    <hr>
    <div id="map">
    	<h3 class="text-success">Hartă</h3>
    	<p>Pagina este dedicată identificării firmei dumneavoastră pe hartă.</p>
    	<p>Pentru aceasta, respectaţi paşii următori:</p>
    	<ol>
    		<li>Poziţionaţi mouse-ul pe locaţia exactă a sediului firmei;</li>
    		<li>Click-dreapta pe hartă (va apărea un simbol ce indică locaţia firmei);</li>
    		<li>Apăsaţi butonul <strong>Submit</strong> pentru a salva locaţia.</li>
    	</ol>
    	<p>Tot pe această pagină, mai puteţi seta:</p>
    	<ul>
    		<li><strong>Numele companiei</strong> (aşa cum doriţi să apară pe cartonaşul de pe hartă);</li>
    		<li><strong>Judeţul</strong>;</li>
    		<li><strong>Oraşul</strong>;</li>
    		<li><strong>Adresa firmei</strong> (vizibilă şi în alte părţi ale site-ului).</li>
    	</ul>
    	<p>Câmpurile <em>Latitudine</em> şi <em>Longitudine</em> nu trebuie completate: acestea se actualizează automat când daţi click-dreapta pe hartă (pasul 2 de mai sus).</p>
    </div>
    <hr>
    <div id="generale">
    	<h3 class="text-success">Setări generale</h3>
    	<p>Pagina conţine următoarele câmpuri:</p>
    	<ul>
    		<li><strong>Google analytics</strong> – aici se adaugă (Ctrl+V) codul Google analytics, în cazul în care aveţi un asemenea cont; după salvare, codul va fi inserat automat în codul sursă al fiecărei pagini;</li>
    		<li><strong>Oraş companie</strong> – numele oraşului în care activează firma dvs;</li>
    		<li><strong>Email de sistem</strong> – adresa de email responsabilă cu trimiterea mesajelor/ notificărilor pe care le veţi primi; această adresă de mail este setată de către dezvoltator şi <strong>nu este recomandabil să o modificaţi, în afară de cazul în care chiar ştiţi ce faceţi</strong>;</li>
    		<li><strong>Email de contact</strong> - setaţi adresa de mail care va fi afişată pe site şi în care veţi primi mesaje;</li>
    		<li><strong>Telefon</strong> - numărul de telefon, doar cifre;</li>
    		<li><strong>Numele site-ului</strong> - numele propriu-zis al site-ului. A nu se confunda cu numele firmei, aşa cum apare acesta pe hartă (în pagina de contact) şi care poate să difere;</li>
    		<li><strong>Cuvinte cheie</strong> - 5-7 cuvinte-cheie, separate de virgulă; cuvintele-cheie aveau valoare la un moment dat, dar nu mai sunt relevante (conform Google) pentru optimizarea motorului de căutare. E posibil ca anumite motoare de căutare secundare să le mai folosească;</li>
    		<li><strong>Meta descriere</strong> - Meta descrierea este importantă pentru că reprezintă fragmentul de text utilizat de către Google, Yahoo etc. atunci când este efectuată o căutare şi sunt afişate rezultatele; setaţi o meta descriere generală a site-ului de maxim 170 de caractere.</li>
    	</ul>
    </div>
    <hr>
    <div id="sociale">
    	<h3 class="text-success">Reţele sociale</h3>
    	<p>Se completează adresele de Facebook, Twitter, Google+ etc. Lăsaţi necompletat dacă doriţi ca adresa respectivă să NU fie afişată pe site.</p>
    	<p><strong>Facebook Meta</strong> – alegeţi o poză sugetstivă care va fi afişată de Facebook când o pagină a site-ului va fi distribuită.</p>
    </div>
    <hr>
    <div id="sitemap">
    	<h3 class="text-success">Sitemap</h3>
    	<p>Sitemap-ul XML reprezintă un index care conţine toate link-urile relevante ale site-ului şi care este utilizat de motoarele de căutare. Este recomandat să fie regenerat după adăugarea unor noi produse/articole etc.</p>
    	<p>Imediat după instalarea site-ului pe server, e bine să evităm totuşi regenerarea sitemap-ului XML înainte de suprimarea/modificarea conţinuturilor demo cu care a fost instalat site-ul, asta deoarece nu este de dorit să notificăm motoarele de căutare în legătură cu acestea.</p>
    </div>
</span>
</div>
</div>
@endsection
