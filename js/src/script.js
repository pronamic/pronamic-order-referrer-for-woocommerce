/* eslint-env jquery */
( function () {
	function processReferrer() {
		if ( '' === document.referrer ) {
			return;
		}

		const date = new Date();
		const referrer = new URL( document.referrer );
		const url = new URL( window.location );

		if ( url.host === referrer.host ) {
			return;
		}

		let referrers = JSON.parse(
			window.localStorage.getItem( 'pronamicReferrers' )
		);

		if ( ! Array.isArray( referrers ) ) {
			referrers = [];
		}

		referrers.unshift( {
			date,
			referrer,
		} );

		window.localStorage.setItem(
			'pronamicReferrers',
			JSON.stringify( referrers.slice( 0, 20 ) )
		);
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		if ( ! document.forms.checkout ) {
			return;
		}

		const input = document.createElement( 'input' );

		input.setAttribute( 'type', 'hidden' );
		input.setAttribute( 'name', 'pronamic_referrers_json' );
		input.setAttribute(
			'value',
			window.localStorage.getItem( 'pronamicReferrers' )
		);

		document.forms.checkout.append( input );
	} );

	processReferrer();
} )();
