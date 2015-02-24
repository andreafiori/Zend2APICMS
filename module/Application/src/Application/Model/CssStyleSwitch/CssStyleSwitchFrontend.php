<?php

namespace Application\Model\CssStyleSwitch;

use Application\Model\RouterManagers\RouterManagerAbstract;
use Application\Model\RouterManagers\RouterManagerInterface;
use Zend\Session\Container as SessionContainer;

/**
 * Change session value about CSS to use
 * 
 */
class CssStyleSwitchFrontend extends RouterManagerAbstract implements RouterManagerInterface
{
    public function setupRecord()
    {
        $param = $this->getInput('param', 1);

        $sessionContainer = new SessionContainer();

        switch($param['route']['cssname']) {
            default:
                $sessionContainer->offsetSet('cssName', "default");
            break;
            
            case("high-visibility"):
                $sessionContainer->offsetSet('cssName', "high-visibility");
            break;

            case("rosso-su-nero"):
                $sessionContainer->offsetSet('cssName', "rosso-su-nero");
            break;
        
            case("text"):
                $sessionContainer->offsetSet('cssName', "text");
            break;
        }

        $redirect = $this->getInput('redirect', 1);
        $redirect->toRoute('home');
        
        return $this->getOutput();
    }
}
