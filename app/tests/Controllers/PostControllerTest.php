<?php
Class PostControllerTest extends TestCase{
	public function testIndex(){
		$response = $this->call("GET","posts");
		$this->assertEquals("all posts",$response->getContent());
	}
	public function testViewPost(){
		// goi orute posts
		$this->call("GET","posts2");
		// xem view co duoc truyen bien post khong
		$this->assertViewHas('post','abc');
	}

	public function testViewHasCollection(){
		$response = $this->call("GET",'posts3');
		// assert co bien posts duong truyen view khong
		$this->assertViewHas('posts');
		// lay bien duoc tuyen cho view
		$posts = $response->original->getData()['posts'];
		// assert kieu du lieu tra ve co phai la mot collection cua eloquent hay kg
		$this->assertInstanceOf("Illuminate\Database\Eloquent\Collection",$posts);
	}

}