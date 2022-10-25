<?php
	
	// ====================== PATHS ===========================
	define ('DS'				, DIRECTORY_SEPARATOR);
	define ('ROOT_PATH'			, dirname(__FILE__));						// Định nghĩa đường dẫn đến thư mục gốc
	define ('LIBRARY_PATH'		, ROOT_PATH . DS . 'libs' . DS);			// Định nghĩa đường dẫn đến thư mục thư viện
	define ('LIBRARY_EXT_PATH'	, LIBRARY_PATH .'extends' . DS);				
	define ('PUBLIC_PATH'		, ROOT_PATH . DS . 'public' . DS);	// Định nghĩa đường dẫn đến thư mục public	
	define ('UPLOAD_PATH'		, PUBLIC_PATH . 'file' . DS);			//Định nghĩa đường dẫn đến thư mục upload	
	define ('SCRIPT_PATH'		, PUBLIC_PATH . 'scripts' . DS);				
	define ('APPLICATION_PATH'	, ROOT_PATH . DS . 'application' . DS);		// Định nghĩa đường dẫn đến thư mục public	
	define ('BLOCK_PATH'	    , APPLICATION_PATH . 'block' . DS);	
	define	('ROOT_URL'			, DS . 'Bookstore-PHP-MySQL/project-final' . DS);
	define ('IMG_DEFAULT_INDEX_PATH'	, 'public' . DS .'template' . DS . 'default' . DS . 'images' . DS);
	define ('IMG_DEFAULT_CATEGORY_PATH'	, ROOT_URL . 'public' . DS .'file' . DS . 'category' . DS );
	

	define ('TEMPLATE_PATH'		, PUBLIC_PATH . 'template' . DS);		// Định nghĩa đường dẫn đến thư mục public							
	

	define ('IMG_DEFAULT_BOOK_PATH'	, ROOT_URL . 'public' . DS .'file' . DS . 'book' . DS );

	define ('IMAGE_PATH'		, ROOT_URL  . 'public' . DS . 'file' . DS .'category' . DS);		//Định nghĩa đường dẫn đến thư mục hình ảnh
	define	('APPLICATION_URL'	, ROOT_URL . 'application' . DS);
	
	define	('PUBLIC_URL'		, ROOT_URL . 'public' . DS);
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template' . DS);
	
	define	('DEFAULT_MODULE'		, 'backend');
	define	('DEFAULT_CONTROLLER'	, 'dashboard');
	define	('DEFAULT_ACTION'		, 'index');

	// ====================== DATABASE ===========================
	define ('DB_HOST'			, 'localhost');
	define ('DB_USER'			, 'root');						
	define ('DB_PASS'			, '');						
	define ('DB_NAME'			, 'project-final');	
	
	
	define ('DB_TABLE'			, 'group');		
	define ('TIME_LOGIN'			, 3600);					
