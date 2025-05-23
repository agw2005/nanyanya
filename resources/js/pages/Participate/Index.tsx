import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { Card } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import React, { useState } from 'react';

const answers = [
  'Answer A',
  'Answer B',
  'Answer C',
  'Answer D',
];

export default function Index() {
  const [selected, setSelected] = useState<number | null>(null);
  const [uncertain, setUncertain] = useState(false);

  return (
    <AppLayout breadcrumbs={[{ title: 'Participate', href: '/participate' }]}> 
      <Head title="Participating a quiz" />
      <div className="flex h-[calc(100vh-100px)] w-full bg-[#444] p-4 gap-4 rounded-xl">
        {/* Sidebar */}
        <div className="flex flex-col items-center bg-[#999] rounded-lg w-40 min-w-[120px] p-4">
          <span className="font-bold text-lg mb-2">Daftar Soal</span>
        </div>
        {/* Main Content */}
        <div className="flex-1 flex flex-col bg-[#aaa] rounded-lg p-6 gap-4">
          {/* Question Section */}
          <div className="flex flex-row items-start justify-between mb-4">
            <div className="flex-1 flex items-center justify-center">
              <span className="text-3xl font-bold">Questions</span>
            </div>
            <div className="flex flex-col items-end gap-2">
              <div className="flex items-center gap-2">
                <Checkbox id="uncertain" checked={uncertain} onCheckedChange={v => setUncertain(!!v)} />
                <Label htmlFor="uncertain" className="text-lg font-semibold">Uncertain</Label>
              </div>
              <div className="flex gap-2">
                <Button variant="outline" size="icon" aria-label="Previous question">{'<'} </Button>
                <Button variant="outline" size="icon" aria-label="Next question">{'>'} </Button>
              </div>
            </div>
          </div>
          {/* Answers */}
          <div className="flex flex-col gap-3 mt-2">
            {answers.map((ans, idx) => (
              <Card
                key={ans}
                className={cn(
                  'w-full px-6 py-4 text-2xl font-bold cursor-pointer transition-colors',
                  selected === idx ? 'bg-[#888] border-2 border-black' : 'bg-[#aaa] border border-black',
                )}
                onClick={() => setSelected(idx)}
              >
                {ans}
              </Card>
            ))}
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
