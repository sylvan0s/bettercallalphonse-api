<?php

namespace App\Doctrine\DQL;

use Doctrine\ORM\Query\Lexer;

class DateFormatFunction extends \Doctrine\ORM\Query\AST\Functions\FunctionNode
{

    protected $dateExpression;

    protected $formatChar;
    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'DATE_FORMAT (' . $sqlWalker->walkArithmeticExpression( $this->dateExpression ) . ',' .
            $sqlWalker->walkStringPrimary( $this->formatChar ) . ')';
    }

    /**
     * @param \Doctrine\ORM\Query\Parser $parser
     *
     * @return void
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->Match( Lexer::T_IDENTIFIER );
        $parser->Match( Lexer::T_OPEN_PARENTHESIS );

        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->Match( Lexer::T_COMMA );

        $this->formatChar = $parser->ArithmeticExpression();

        $parser->Match( Lexer::T_CLOSE_PARENTHESIS );
    }
}