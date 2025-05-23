import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Participate',
        href: '/participate',
    },
];

const boxes = new Array(20).fill(0); // Example with 20 components

export default function Index() {
    // Placeholder state for uncertain checkbox
    const [uncertain, setUncertain] = useState(false);
    // Placeholder state for current question index
    const [currentQuestion, setCurrentQuestion] = useState(0);
    // Placeholder data
    const question = 'Questions';
    const answers = ['Answer A', 'Answer B', 'Answer C', 'Answer D'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Participating a quiz" />
            <div className="flex h-[calc(100vh-32px)] bg-[#444] p-2 rounded-lg">
                {/* Sidebar */}
                <div className="w-40 bg-[#aaa] rounded-md flex flex-col items-center justify-center mr-4">
                    <span className="font-semibold text-lg text-black rotate-[-0.5deg] select-none">Daftar Soal</span>
                </div>
                {/* Main Content */}
                <div className="flex-1 flex flex-col bg-[#aaa] rounded-md p-6 relative">
                    {/* Question */}
                    <div className="flex justify-between items-start mb-4">
                        <div className="flex-1 flex items-center justify-center">
                            <span className="text-3xl font-bold text-black">{question}</span>
                        </div>
                        <div className="flex flex-col items-end gap-2">
                            <label className="flex items-center gap-2 bg-[#bbb] px-2 py-1 rounded border border-[#888]">
                                <input
                                    type="checkbox"
                                    checked={uncertain}
                                    onChange={() => setUncertain((v) => !v)}
                                    className="w-6 h-6 accent-white border border-black rounded"
                                />
                                <span className="font-semibold text-black">Uncertain</span>
                            </label>
                            <div className="flex gap-2 mt-2">
                                <button
                                    className="w-10 h-10 bg-[#888] rounded border border-[#444] text-2xl font-bold text-black flex items-center justify-center hover:bg-[#999]"
                                    onClick={() => setCurrentQuestion((q) => Math.max(0, q - 1))}
                                >
                                    {'<'}
                                </button>
                                <button
                                    className="w-10 h-10 bg-[#888] rounded border border-[#444] text-2xl font-bold text-black flex items-center justify-center hover:bg-[#999]"
                                    onClick={() => setCurrentQuestion((q) => q + 1)}
                                >
                                    {'>'}
                                </button>
                            </div>
                        </div>
                    </div>
                    {/* Answers */}
                    <div className="flex flex-col gap-3 mt-2">
                        {answers.map((ans, idx) => (
                            <div
                                key={idx}
                                className="bg-[#888] rounded px-4 py-2 text-2xl font-bold text-black border border-[#444] cursor-pointer select-none"
                            >
                                {ans}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
