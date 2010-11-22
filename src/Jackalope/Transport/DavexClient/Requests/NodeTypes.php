<?php
/**
 * Class to handle the communication between Jackalope and Jackrabbit via Davex.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0, January 2004
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 *
 * @package jackalope
 * @subpackage transport
 */

namespace Jackalope\Transport\DavexClient\Requests;


/**
 * Class to handle a NodeTypes request.
 *
 * @package jackalope
 * @subpackage transport
 */
class NodeTypes extends \Jackalope\Transport\DavexClient\Requests\Base {

    /**
     * Identifier of the used XML namespace
     * @var string
     */
    protected $nsPrefix = 'jcr';

    /**
     * URI of the used XML namespace
     * @var string
     */
    protected $nsUri = 'http://www.day.com/jcr/webdav/1.0';

    /**
     * Generates the DOMDocument representing the request to be send.
     *
     * @throws \InvalidArgumentException
     */
    public function build() {

        if (!isset($this->arguments['nodetypes'])) {
            throw new \InvalidArgumentException('Missing NodeTypes.');
        }

        // root element
        //<jcr:nodetypes xmlns:jcr="http://www.day.com/jcr/webdav/1.0">
        $doc = $this->dom->createElementNS($this->nsUri, $this->nsPrefix.':nodetypes');

        if (empty($this->arguments['nodetypes'])) {
            // <jcr:all-nodetypes/>
            $nType = $this->dom->createElement('jcr:all-nodetypes');
            $doc->appendChild($nType);
        } else {
            foreach ($this->arguments['nodetypes'] as $nodetype) {
                // '<jcr:nodetype><jcr:nodetypename>'.$nodetype.'</jcr:nodetypename></jcr:nodetype>';
                $nType = $this->dom->createElement('jcr:nodetype');
                $nTypeName = $this->dom->createElement('jcr:nodetypename', $nodetype);
                $nType->appendChild($nTypeName);
                $doc->appendChild($nType);
            }
        }
        $this->dom->appendChild($doc);
    }
}