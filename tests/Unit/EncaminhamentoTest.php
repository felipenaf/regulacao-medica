<?php

namespace Tests\Unit;

use App\Encaminhamento;
use App\Status;
use PHPUnit\Framework\TestCase;

class EncaminhamentoTest extends TestCase
{
    private $encaminhamento;

    protected function setUp(): void
    {
        $this->encaminhamento = new Encaminhamento();
    }

    public function testStatus()
    {
        $this->encaminhamento->id_status = Status::PENDENTE;
        $this->assertTrue($this->encaminhamento->pendente());

        $this->encaminhamento->id_status = Status::APROVADO;
        $this->assertTrue($this->encaminhamento->aprovado());

        $this->encaminhamento->id_status = Status::REPROVADO;
        $this->assertTrue($this->encaminhamento->reprovado());
    }

    public function testDateField()
    {
        $this->assertSame(
            'data_criacao',
            $this->encaminhamento::CREATED_AT
        );

        $this->assertSame(
            'data_atualizacao',
            $this->encaminhamento::UPDATED_AT
        );
    }

    public function testFillables()
    {
        $fillables = $this->encaminhamento->getFillable();

        $this->assertSame([
            'id_paciente',
            'id_especialidade',
            'id_status',
            'descricao',
            'id_medico_familia',
        ], $fillables);
    }
}
