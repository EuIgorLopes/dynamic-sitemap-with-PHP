<?php
	class SiteMap{
		public function index(){
			//Define a verção do encode.
			//Define the encode version.
			$xml = new DOMDocument( "1.0", "UTF-8" );

			//Retirar espaços em branco.
			//Remove white spaces.
			$xml->preserveWhiteSpace = false;

			//Ativa a formatação do documento (indentação).
			//Active the document format (indentation).
			$xml->formatOutput = true;

			//Cria elementos.
			//Create elements.
			$urlset = $xml->createElement( "urlset" );
			$url = $xml->createElement( "url" );

			//Cria os atributos para urlset.
			//Create attributes for urlset.
			$urlset->setAttribute( "xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9" );
			$urlset->setAttribute( "xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance" );
			$urlset->setAttribute( "xsi:schemaLocation", "http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" );

			//Cria elementos e define o conteúdo dentro deles.
			//Create elements and define your content.
			$loc = $xml->createElement( "loc", "http://www.mysite.com.br/" );
			$changefreq = $xml->createElement( "changefreq", "daily" );
			$priority = $xml->createElement( "priority", "1.00" );

			//Anexa elementos ao seu elemento pai.
			//Append elements in your father element.
			$url->appendChild( $loc );
			$url->appendChild( $changefreq );
			$url->appendChild( $priority );
			$urlset->appendChild( $url );

			/*
				Neste momento, é necessário fazer uma consulta ao banco utilizando mysqli ou PDO para retornar as URLs e suas frenquencias de atualiação junto com suas prioridades e ultima atualização.
			*/
			/*
				In this moment, it is necessary to access the database with mysqli or PDO for return the URLs and your update frequency, together your priorities and last update.
			*/

			$query="SELECT 'url_site', 'last_update' 'update_frequency', 'priority' FROM table";

			//Resultados da busca.
			//Search results.
			$query_results=array();

			foreach ($query_results as $value) {
				//Cria um novo elemento URL.
				//Create a new element URL.
				$url = $xml->createElement( "url" );

				//Cria um novo elemento com a URL selecionada do banco de dados.
				//Create a new element with URL selected in database.
				$loc = $xml->createElement( "loc", $value["url_site"] );

				//Cria um novo elemento com a ultima atuialização da URL.
				//Create a new element with last URL update.
				$lastmod = $xml->createElement( "lastmod", $value["last_update"] );

				/*
					Cria um novo elemento com a frequencia de atualização da URL.
					Os valores de changefreq podem ser always, hourly, daily, weekly, monthly, yearly e never.
				*/
				/*
					Create a new element with update URL frequency.
					the values for changefreq can be always, hourly, daily, weekly, monthly, yearly and never.
				*/
				$changefreq = $xml->createElement( "changefreq", $value["update_frequency"] );

				//Cria um novo elemento com a prioridade da URL. A prioridade pode variar entre 0.0 e 1.0
				//Create a new element with URL priority. The priority can be variable between 0.0 and 1.0
				$priority = $xml->createElement( "priority", $value["priority"] );

				//Anexa elementos ao seu elemento pai.
				//Append elements in your father element.
				$url->appendChild( $loc );
				$url->appendChild( $changefreq );
				$url->appendChild( $lastmod );
				$url->appendChild( $priority );

				//Vários elementos URL são criados para o elemento urlset.
				//Multiple URL elements are created for the urlser element.
				$urlset->appendChild( $url );
			}

			$xml->appendChild( $urlset );

			//Salva o documento.
			//Save the document.
			$xml->save("sitemap.xml");
			print $xml->saveXML();
		}
	}