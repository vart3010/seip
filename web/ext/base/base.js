/* 
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Formatea un numero a dos decimales
 * @param {type} val
 * @returns {unresolved}
 */
var formatNumber = function (val) {
    return Ext.util.Format.number(Ext.util.Format.number(val, '0.000,00/i'));
};