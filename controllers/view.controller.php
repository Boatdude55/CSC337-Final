<?php 
include dirname(__DIR__) . "/models/view.model.php";

/**
 * ViewController
 * I like this because I just feed it an data object
 * and it constructs the view based on the view model
 * The result of a selection is either an array of associative array or an associative array = data
 * Ignore the view that was when I messed and I was making a single page app in a horrible way
 * But the template is useful b/c ...
 * given an associative array
 * the template keys = associative key
 * For each template key it describes the view for that piece of data
 * */
 
class ViewController{
	
	private $views = NULL;
	private $template = NULL;
	
	public function __construct( $template, $views ) {
		
		$this->views = $template;
		$this->template = $views;
	}
	
	public function formatQuotes ( $data ) {
		
		return $this->constructTemplateView($data);
		
	}
	
	/**
	 * Here my case for why I think its useful
	 * All you have to do is change the key names and the html in head and tail
	 * @param array $data
	 * @return string
	 * */
	private function constructTemplateView ( $data = false ) {
		
		$temp = array();
		
		/**
		 * create temp array for later storage
		 * if $data array > 1 b/c PDO return array of length 1 even for empty results
		 * */
		if ( count($data) > 1 ) {
			
			/**
			 * foreach loop for keys and values
			 * the key is a number; PDO returns numbered indexes for array of data
			 * val is an associative array of a row that satisfied the query
			 * */
			foreach ( $data as $key => $val ) {
				
				try{
					/**
					 * You can remove this check; it's here b/c i was getting wierd results when testing
					 * */
					if ( is_array($this->template['div']['content']) ) {
						
						/**
						 * I have the current key and val of the data array
						 * I foreach through my template keys and values
						 * */
						foreach ( $this->template['div']['content'] as $k=>$v ) {
							
							/**
							 * When a key from my template matches the a key for my val( a row from a table)
							 * take that template key's content and insert the val[k](which is a colums data)
							 * implode a string in temp
							 * reset template key's content
							 * */
							if ( isset( $val[$k]) ) {
								
								$this->template['div']['content'][$k]['content'] = $val[$k];
								
								$temp[] = implode('',$this->template['div']['content'][$k]);
								
								$this->template['div']['content'][$k]['content'] = '';
							}
							
						}
					}
					/**
					 * End result of this foreach is temp filled with a string of all data results:
					 * which are in a view in the order set by template
					 * and with html set by the template
					 * */
				}catch ( Exception $error) {
					
					$message = "Error binding data to html" . $error->getMessage();
					throw new Error($message);
					
				}
			}
			
			/**
			 * implode temp(data string) into the container
			 * */
			$this->template['div']['content'] = implode('', $temp);
			
			/**
			 * implode the container
			 * */
			$temp = implode('', $this->template['div']);
			
			/** reset **/
			$this->template['div']['content'] = '';
			
		}else {
			
			$temp = "All data is flagged";
			
		}
		
		
		return $temp;
		
		
	}
}

$viewController = new ViewController( $VIEWS, $QuoteTemplate );

//Tests

//	$res = $viewController->renderView('register');
//	echo htmlspecialchars($res);

//	$res = $viewController->renderView('login');
//	echo htmlspecialchars($res);

//	$res = $viewController->renderView('quotes');
//	echo htmlspecialchars($res);
?>