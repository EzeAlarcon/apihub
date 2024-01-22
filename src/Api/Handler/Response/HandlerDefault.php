<?php
/**
 * B2W Digital - Companhia Digital
 *
 * Do not edit this file if you want to update this SDK for future new versions.
 * For support please contact the e-mail bellow:
 *
 * sdk@e-smart.com.br
 *
 * @category  SkyHub
 * @package   SkyHub
 *
 * @copyright Copyright (c) 2018 B2W Digital - BSeller Platform. (http://www.bseller.com.br).
 *
 * @author    Tiago Sampaio <tiago.sampaio@e-smart.com.br>
 * @author    Bruno Gemelli <bruno.gemelli@e-smart.com.br>
 */

namespace SkyHub\Api\Handler\Response;

use GuzzleHttp\Psr7\Response;

class HandlerDefault extends HandlerAbstract implements HandlerInterfaceSuccess
{
    
    /** @var Response */
    protected $httpResponse = null;

    protected $bodyContent = null;
    
    
    /**
     * DefaultHandler constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->httpResponse = $response;
    }
    
    
    /**
     * @return Response
     */
    public function httpResponse()
    {
        return $this->httpResponse;
    }
    
    
    /**
     * @return mixed|string
     */
    public function body()
    {
        return $this->bodyString();
    }
    
    
    /**
     * @return string
     */
    public function bodyString()
    {
        return (string) $this->httpResponse()->getBody();
    }
    
    
    /**
     * @param bool $assoc
     * @param int  $depth
     * @param int  $options
     *
     * @return array|\stdClass
     */
    public function toArray($assoc = true, $depth = 512, $options = 0)
    {
        return json_decode($this->bodyString(), $assoc, $depth, $options);
    }
    
    
    /**
     * @return int|null
     */
    public function bodySize()
    {
        return $this->httpResponse()->getBody()->getSize();
    }
    
    
    /**
     * @return mixed|\string[][]
     */
    public function headers()
    {
        return $this->httpResponse()->getHeaders();
    }
    
    
    /**
     * @return mixed|string
     */
    public function protocolVersion()
    {
        return $this->httpResponse()->getProtocolVersion();
    }
    
    
    /**
     * @return int|mixed
     */
    public function statusCode()
    {
        return $this->httpResponse()->getStatusCode();
    }
    
    
    /**
     * @return string
     */
    public function reasonPhrase()
    {
        return $this->httpResponse()->getReasonPhrase();
    }
    
    
    /**
     * @return bool
     */
    public function success()
    {
        return true;
    }
    
    
    /**
     * @return bool
     */
    public function exception()
    {
        return false;
    }
    
    
    /**
     * @return bool
     */
    public function invalid()
    {
        return false;
    }
    
    
    /**
     * @return array
     */
    public function export()
    {
        return [
            'body'             => $this->body(),
            'body_size'        => $this->bodySize(),
            'headers'          => $this->headers(),
            'protocol_version' => $this->protocolVersion(),
            'status_code'      => $this->statusCode(),
            'reason_phrase'    => $this->reasonPhrase(),
        ];
    }
}