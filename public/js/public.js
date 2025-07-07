function isExternalLink( url )
{
	var link = new URL( url, window.location.origin );
	
	return link.hostname !== window.location.hostname;
}

/*
 * MiniPreview v0.9
 *
 * @author  Will Boyd
 * @github  http://github.com/lonekorean/mini-preview
 */
( function( $ )
{
	var PREFIX = 'mini-preview';
	
	// implemented as a jQuery plugin
	$.fn.miniPreview = function( options )
	{
		return this.each( function()
		{
			var $this = $( this );

			if ( MiniLivePreviewUrl.previewLinkType == 'internal_only' && isExternalLink( $this.href ) )
			{
				return;
			}

			if ( MiniLivePreviewUrl.previewLinkType == 'external_only' && ! isExternalLink( $this.href ) )
			{
				return;
			}
			
			var miniPreview = $this.data( PREFIX );
			
			if ( miniPreview )
			{
				miniPreview.destroy();
			}

			miniPreview = new MiniPreview( $this, options );
			
			miniPreview.generate();
			
			$this.data( PREFIX, miniPreview );
		} );
	};
	
	var MiniPreview = function( $el, options )
	{
		this.$el = $el;
		
		this.$el.addClass( PREFIX + '-anchor' );
		
		this.options = $.extend( {}, this.defaultOptions, options );
		
		this.counter = MiniPreview.prototype.sharedCounter++;
	};
	
	MiniPreview.prototype =
	{
		sharedCounter: 0,
		
		defaultOptions:
		{
			width: 300,
			height: 200,
			scale: 0.25,
			prefetch: 'parenthover'
		},
				
		generate: function()
		{
			this.createElements();
			
			this.setPrefetch();
		},

		createElements: function()
		{
			var $wrapper = $( '<div>', { class: PREFIX + '-wrapper' } );
			
			var $loading = $( '<div>', { class: PREFIX + '-loading' } );
			
			var $frame = $( '<iframe>', { class: PREFIX + '-frame' } );
			
			var $cover = $( '<div>', { class: PREFIX + '-cover' } );
			
			$wrapper.appendTo( this.$el ).append( $loading, $frame, $cover );
			
			// sizing
			$wrapper.css( {
				width: this.options.width + 'px',
				height: this.options.height + 'px'
			} );
			
			// scaling
			var inversePercent = 100 / this.options.scale;
			
			$frame.css( {
				width: inversePercent + '%',
				height: inversePercent + '%',
				transform: 'scale( ' + this.options.scale + ' )',
				overflow: 'hidden'
			} );

			$frame.attr( 'scrolling', 'no' );

			// positioning
			var fontSize = parseInt( this.$el.css( 'font-size' ).replace( 'px', '' ), 10 );
			
			var top = ( this.$el.height() + fontSize ) / 2;
			
			var left = ( this.$el.width() - $wrapper.outerWidth() ) / 2;
			
			$wrapper.css( {
				top: top + 'px',
				left: left + 'px'
			} );
		},
		
		setPrefetch: function()
		{
			switch ( this.options.prefetch )
			{
				case 'pageload':
					this.loadPreview();
				break;
				
				case 'parenthover':
					this.$el.parent().one( this.getNamespacedEvent( 'mouseenter' ), this.loadPreview.bind( this ) );
				break;
				
				case 'none':
					this.$el.one( this.getNamespacedEvent( 'mouseenter' ), this.loadPreview.bind( this ) );
				break;
				
				default:
					throw 'Prefetch setting not recognized: ' + this.options.prefetch;
			}
		},
		
		loadPreview: function()
		{
			this.$el.find( '.' + PREFIX + '-frame' ).attr( 'src', this.$el.attr( 'href' ) ).on( 'load', function()
			{
				// some sites don't set their background color
				$( this ).css( 'background-color', '#fff' );
			} );
		},
		
		getNamespacedEvent: function( event )
		{
			return event + '.' + PREFIX + '_' + this.counter;
		},

		destroy: function()
		{
			this.$el.removeClass( PREFIX + '-anchor' );
			
			this.$el.parent().off( this.getNamespacedEvent( 'mouseenter' ) );
			
			this.$el.off( this.getNamespacedEvent( 'mouseenter' ) );
			
			this.$el.find( '.' + PREFIX + '-wrapper' ).remove();
		}
	};
} )( jQuery );

jQuery( document ).ready( function( $ )
{
	var contentContainer1 = $( 'body #content' );
	
	var contentContainer2 = $( 'body .content' );
	
	var contentContainer3 = $( 'body .site-content' );
	
	var contentContainer4 = $( 'body #site-content' );

	var contentContainer5 = $( 'body .wp-site-blocks' );
	
	if ( contentContainer1.length )
	{
		contentContainer1.find( 'a' ).miniPreview( { prefetch: 'none' } );
	}
	else if ( contentContainer2.length )
	{
		contentContainer2.find( 'a' ).miniPreview( { prefetch: 'none' } );
	}
	else if ( contentContainer3.length )
	{
		contentContainer3.find( 'a' ).miniPreview( { prefetch: 'none' } );
	}
	else if ( contentContainer4.length )
	{
		contentContainer4.find( 'a' ).miniPreview( { prefetch: 'none' } );
	}
	else if ( contentContainer5.length )
	{
		contentContainer5.find( 'a' ).miniPreview( { prefetch: 'none' } );
	}
} );