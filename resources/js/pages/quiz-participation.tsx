import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { Card } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import React, { useState } from 'react';

// Types for the quiz prop
interface Option {
  id: number;
  label: string; // 'A', 'B', etc.
  text: string;
}
interface Question {
  id: number;
  text: string;
  options: Option[];
}
interface Quiz {
  id: number;
  name: string;
  questions: Question[];
}

interface Props {
  quiz: Quiz;
}

export default function QuizParticipation({ quiz }: Props) {
  const [current, setCurrent] = useState(0);
  const [selected, setSelected] = useState<number | null>(null);
  const [uncertain, setUncertain] = useState(false);
  const question = quiz.questions[current];

  return (
    <AppLayout breadcrumbs={[{ title: 'Participate', href: '/participate' }]}> 
      <Head title={`Participating: ${quiz.name}`} />
      <div className="flex h-[calc(100vh-100px)] w-full bg-[#444] p-4 gap-4 rounded-xl">
        {/* Sidebar */}
        <div className="flex flex-col items-center bg-[#999] rounded-lg w-40 min-w-[120px] p-4">
          <span className="font-bold text-lg mb-2">Daftar Soal</span>
          {/* List of questions */}
          <div className="flex flex-col gap-2 mt-4">
            {quiz.questions.map((q, idx) => (
              <Button
                key={q.id}
                size="sm"
                variant={current === idx ? 'secondary' : 'outline'}
                className="w-full"
                onClick={() => {
                  setCurrent(idx);
                  setSelected(null);
                  setUncertain(false);
                }}
              >
                {idx + 1}
              </Button>
            ))}
          </div>
        </div>
        {/* Main Content */}
        <div className="flex-1 flex flex-col bg-[#aaa] rounded-lg p-6 gap-4">
          {/* Question Section */}
          <div className="flex flex-row items-start justify-between mb-4">
            <div className="flex-1 flex flex-col items-center justify-center">
              <span className="text-2xl font-bold mb-2">{quiz.name}</span>
              <span className="text-3xl font-bold">{question?.text || 'No question'}</span>
            </div>
            <div className="flex flex-col items-end gap-2">
              <div className="flex items-center gap-2">
                <Checkbox id="uncertain" checked={uncertain} onCheckedChange={v => setUncertain(!!v)} />
                <Label htmlFor="uncertain" className="text-lg font-semibold">Uncertain</Label>
              </div>
              <div className="flex gap-2">
                <Button
                  variant="outline"
                  size="icon"
                  aria-label="Previous question"
                  disabled={current === 0}
                  onClick={() => {
                    setCurrent((c) => Math.max(0, c - 1));
                    setSelected(null);
                    setUncertain(false);
                  }}
                >
                  {'<'}
                </Button>
                <Button
                  variant="outline"
                  size="icon"
                  aria-label="Next question"
                  disabled={current === quiz.questions.length - 1}
                  onClick={() => {
                    setCurrent((c) => Math.min(quiz.questions.length - 1, c + 1));
                    setSelected(null);
                    setUncertain(false);
                  }}
                >
                  {'>'}
                </Button>
              </div>
            </div>
          </div>
          {/* Answers */}
          <div className="flex flex-col gap-3 mt-2">
            {question?.options?.map((opt, idx) => (
              <Card
                key={opt.id}
                className={cn(
                  'w-full px-6 py-4 text-2xl font-bold cursor-pointer transition-colors',
                  selected === idx ? 'bg-[#888] border-2 border-black' : 'bg-[#aaa] border border-black',
                )}
                onClick={() => setSelected(idx)}
              >
                {opt.label}. {opt.text}
              </Card>
            ))}
          </div>
        </div>
      </div>
    </AppLayout>
  );
} 