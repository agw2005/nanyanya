import { useState } from 'react';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

// Placeholder quiz questions data
const quizQuestions = [
    {
        question: 'What is PyTorch?',
        choices: ['A deep learning library', 'A web browser', 'A database', 'A text editor'],
        userChoice: 0,
        correctAnswer: 0,
    },
    {
        question: 'Who is the creator of Python?',
        choices: ['Elon Musk', 'Guido van Rossum', 'Bill Gates', 'Linus Torvalds'],
        userChoice: 1,
        correctAnswer: 1,
    },
    {
        question: 'Which company developed PyTorch?',
        choices: ['Google', 'Facebook', 'Microsoft', 'Amazon'],
        userChoice: 2,
        correctAnswer: 1,
    },
];

export default function Index() {
    const [selectedQuiz, setSelectedQuiz] = useState<number | null>(null);

    return (
        <AppLayout breadcrumbs={[]}> {/* No breadcrumbs as per image */}
            <Head title="Quiz Taken" />
            {/* Quiz Statistics section */}
            <div className="flex justify-start mt-8 mb-6 px-8">
                <div className="text-lg space-y-1">
                    <div>Quiz name : PyTorch Exam</div>
                    <div>Quiz maker : Dicky</div>
                    <div>Number of questions : 10</div>
                    <div>Correct answers : 5</div>
                    <div>Score : 50%</div>
                </div>
            </div>

            {/* Quiz grid - match dashboard */}
            <div className="m-7 grid grid-cols-4 gap-4">
                {[...Array(10)].map((_, i) => (
                    <div
                        key={i}
                        className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] cursor-pointer overflow-hidden rounded-xl border"
                        onClick={() => setSelectedQuiz(i)}
                    >
                        <img
                            src="placeholder-image.jpg"
                            alt={`Quiz ${i + 1}`}
                            className="absolute inset-0 size-full object-cover opacity-80"
                        />
                    </div>
                ))}
            </div>

            {/* Modal for quiz details */}
            {selectedQuiz !== null && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50" onClick={() => setSelectedQuiz(null)}>
                    <div
                        className="w-full max-w-2xl bg-white dark:bg-gray-900 rounded-xl p-8 overflow-y-auto max-h-[90vh]"
                        onClick={e => e.stopPropagation()}
                    >
                        <h2 className="text-2xl font-bold mb-6">Quiz Details</h2>
                        <div className="space-y-8">
                            {quizQuestions.map((q, idx) => (
                                <div key={idx}>
                                    <div className="mb-2 font-semibold">{idx + 1}. {q.question}</div>
                                    <div className="grid grid-cols-1 gap-2">
                                        {q.choices.map((choice, cidx) => {
                                            const isUser = cidx === q.userChoice;
                                            const isCorrect = cidx === q.correctAnswer;
                                            return (
                                                <div
                                                    key={cidx}
                                                    className={`px-4 py-2 rounded border transition-all
                                                        ${isCorrect ? 'bg-green-200 border-green-500' : 'bg-gray-100 border-gray-300'}
                                                        ${isUser ? 'ring-2 ring-blue-400 border-blue-400' : ''}
                                                        flex items-center`}
                                                >
                                                    {choice}
                                                    {isCorrect && (
                                                        <span className="ml-2 text-green-700 font-bold">(Correct)</span>
                                                    )}
                                                    {isUser && !isCorrect && (
                                                        <span className="ml-2 text-blue-700 font-bold">(Your choice)</span>
                                                    )}
                                                </div>
                                            );
                                        })}
                                    </div>
                                </div>
                            ))}
                        </div>
                        <button
                            className="mt-8 w-full py-2 rounded bg-red-500 text-white font-bold hover:bg-red-600"
                            onClick={() => setSelectedQuiz(null)}
                        >
                            Close
                        </button>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
