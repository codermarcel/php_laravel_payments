<?php

namespace App\Http\Middleware;

use App\Contracts\Jwt\Audience;
use App\Exceptions\ClientException\JwtException;
use App\Service\Jwt\JwtParser;
use Closure;

class AnonymousAuth
{
	private $parser;

	public function __construct(JwtParser $parser)
	{
		$this->parser = $parser;
	}


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$token = $this->parser->getToken($request);
    	$audience = $this->parser->getAudience($token);

    	if ($audience !== Audience::ANONYMOUS)
    	{
    		throw JwtException::badAudience();
    	}

        return $next($request);
    }
}
