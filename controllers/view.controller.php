<?php 
include dirname(__DIR__) . "/models/view.model.php";

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
	
	public function renderIndex ( $priveledge, $data ) {
		
		$header = ''; $main = '';
		
		if ( $priveledge ) {
			
			$head = $this->views['index']['head-content']['admin'];
			
		}else{
			
			$head = $this->views['index']['head-content']['default'];
			
		}
		
		
		$main = implode('', array($this->views['index']['main-content']['head'], $data, $this->views['index']['main-content']['tail']));

		return $head . $main;
		
	}
	
	private function constructTemplateView ( $data = false ) {
		
		$temp = array();
		
		if ( count($data) > 1 ) {

			foreach ( $data as $key => $val ) {
				
				try{
					if ( is_array($this->template['div']['content']) ) {
						
						foreach ( $this->template['div']['content'] as $k=>$v ) {
							
							if ( isset( $val[$k]) ) {
								
								$this->template['div']['content'][$k]['content'] = $val[$k];
								
								$temp[] = implode('',$this->template['div']['content'][$k]);
								
								$this->template['div']['content'][$k]['content'] = '';
							}
							
						}
					}
				}catch ( Exception $error) {
					
					$message = "Error binding data to html" . $error->getMessage();
					throw new Error($message);
					
				}
			}
			

			$this->template['div']['content'] = implode('', $temp);
			
			$temp = implode('', $this->template['div']);
			
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