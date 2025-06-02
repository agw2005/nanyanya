import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quiz Taken',
        href: '/quiz-taken',
    },
];

type Choice = {
    id: number;
    label: string;
    option_text: string;
    is_correct: number;
};

type Answer = {
    question_id: number;
    selected_option: string; // e.g. "A", "B"
};

type Question = {
    id: number;
    question_text: string;
    options: Choice[];
};

type Quiz = {
    thumbnail_url: string;
    id: number;
    name: string;
    user: {
        name: string;
    };
    questions: Question[];
    answers: Answer[];
};

type Props = {
    quizzes: Quiz[];
};

export default function Index({ quizzes }: Props) {
    const [selectedQuiz, setSelectedQuiz] = useState<Quiz | null>(null);

    const getCorrectCount = (quiz: Quiz) => {
        return quiz.answers.filter((answer) => {
            const question = quiz.questions.find((q) => q.id === answer.question_id);
            const correctChoice = question?.options.find((opt) => opt.is_correct === 1);
            return correctChoice?.label === answer.selected_option;
        }).length;
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quiz Taken" />

            {selectedQuiz && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50" onClick={() => setSelectedQuiz(null)}>
                    <div className="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-xl bg-gray-900 p-8" onClick={(e) => e.stopPropagation()}>
                        <h2 className="mb-6 text-2xl font-bold">Quiz Details: {selectedQuiz.name}</h2>
                        <div className="space-y-8">
                            {selectedQuiz.questions.map((question, idx) => {
                                const answer = selectedQuiz.answers.find((a) => a.question_id === question.id);
                                return (
                                    <div key={question.id}>
                                        <div className="mb-2 font-semibold">
                                            {idx + 1}. {question.question_text}
                                        </div>
                                        <div className="grid grid-cols-1 gap-2">
                                            {question.options.map((choice) => {
                                                const isUser = answer?.selected_option === choice.label;
                                                const isCorrect = choice.is_correct === 1;

                                                return (
                                                    <div
                                                        key={choice.id}
                                                        className={`rounded border px-4 py-2 transition-all ${isCorrect ? 'border-green-500' : 'border-gray-500 bg-[#262626]'} ${isUser ? 'border-blue-400 ring-2 ring-blue-400' : ''} flex items-center`}
                                                    >
                                                        {choice.option_text}
                                                        {isCorrect && <span className="ml-2 font-bold text-green-300">(Correct)</span>}
                                                        {isUser && !isCorrect && <span className="ml-2 font-bold text-blue-300">(Your choice)</span>}
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                        <button
                            className="mt-8 w-full rounded bg-red-500 py-2 font-bold text-white hover:bg-red-600"
                            onClick={() => setSelectedQuiz(null)}
                        >
                            Close
                        </button>
                    </div>
                </div>
            )}

            <div className="grid grid-cols-4 gap-4 p-4">
                {quizzes.map((quiz) => {
                    const correct = getCorrectCount(quiz);
                    const score = Math.round((correct / quiz.questions.length) * 100);
                    return (
                        <div
                            key={quiz.id}
                            className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] cursor-pointer overflow-hidden rounded-xl border"
                            onClick={() => setSelectedQuiz(quiz)}
                        >
                            <img
                                src={quiz.thumbnail_url ?? 'placeholder-image.jpg'}
                                alt={quiz.name}
                                className="absolute inset-0 size-full object-cover opacity-80"
                            />
                            <div className="absolute right-0 bottom-0 left-0 bg-black/60 p-2 text-sm text-white">
                                <div>{quiz.name}</div>
                                <div>By: {quiz.user.name}</div>
                                <div>
                                    Score: {score}% ({correct}/{quiz.questions.length})
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </AppLayout>
    );
}
